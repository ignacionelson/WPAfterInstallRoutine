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
include_once './classes/'.DS.'MainView.php';
$main_view = new WPAfterInstallRoutine\MainView();
$status = new WPAfterInstallRoutine\ExecutionStatus($main_view);

// Start by including the main WP file
$wp_main_file = '../wp-load.php';
if (!file_exists($wp_main_file))
{
    $e = sprintf("The main WP file could not be loaded from %s", $wp_main_file);
    $status->addError($e);
}

// Get options from the configuration file
$config_file = 'config.json';
if (!file_exists($config_file)) {
    $e = sprintf("The configuration file (%s) does not exist", $config_file);
    $status->addError($e);
}

// End if the required files are not found
if ($status->hasErrors()) {
    $status->endScript();
}

$raw_options = file_get_contents($config_file);
$options = json_decode($raw_options);

// Load and run the tasks
$tasks = new WPAfterInstallRoutine\Tasks($status, $main_view, $options);
$tasks->runTasks();

$status->endScript();