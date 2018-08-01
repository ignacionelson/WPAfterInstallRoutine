<?php
/**
 * WPAfterInstallRoutine
 * Simple, extendable script designed to run after doing a new WP installation.
 * 
 * Based on a custom routine that I like.
 * The default routine follows my own personal preferences but it can be easily
 * modified to add/remove functions via tasks.
 *  
 * Settings for each task and plugin list are defined on the file config.json
 * 
 * It is assumed that this script is run one directory deeper
 * from the main WP folder, so wp-load.php is searched for on ../
 * 
 * @author Ignacio Nelson <info@subwaydesign.com.ar>
 */
define('DS', DIRECTORY_SEPARATOR);

include_once './functions.php';
include_once './classes/'.DS.'ExecutionStatus.php';
include_once './classes/'.DS.'Tasks.php';
include_once './classes/'.DS.'Task.php';
$tasks_files = glob('./classes'.DS.'tasks'.DS.'*.php');
foreach ($tasks_files as $task_file) {
    include_once $task_file;
}
$status = new WPAfterInstallRoutine\ExecutionStatus();

// Start by including the main WP file
$wp_main_file = '../wp-load.php';
if (!file_exists($wp_main_file))
{
    $e = sprintf("The main WP file could not be loaded from %s", $wp_main_file);
    $status->addError($e)->endScript();
}

// Get options from the configuration file
$config_file = 'config.json';
if (file_exists($config_file)) {
    $raw_options = file_get_contents($config_file);
    $options = json_decode($raw_options);
}

/**
 * Proposed inital tasks:
 *      - Remove "old" themes
 *      - Download and install plugins defined on the configuration file
 *      - Install plugins from the premium_plugins directory
 *      - Activate all installed plugins
 *      - Create .htaccess file if it doesn't exist. Populate with safe default information.
 *      - Update the options table with values defined on the configuration file
 *      - Set permalink structure (if in options & .htaccess was created succesfully)
 *      - Checks
 *          - If options-table->siteurl has https
 *      - E-mail execution results
 *      - Self-delete
 */
$tasks = new WPAfterInstallRoutine\Tasks($status, $options);
$tasks->runTasks();

$status->endScript();