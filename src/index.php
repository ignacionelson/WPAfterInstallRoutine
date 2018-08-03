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
 * @link https://github.com/ignacionelson/WPAfterInstallRoutine
 * @license https://www.gnu.org/licenses/gpl.html GNU GPL version 3
 */

error_reporting(E_ALL);

/**
 * Set time limit to 10 minutes. There's no need to set it at 0 and keep it
 * running until the next Big Bang if something fails
 */
set_time_limit(600);

define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('WP_MAIN_FILE', dirname(ROOT).DS."wp-load.php");
define('CONFIG_FILE', ROOT.DS."config.json");
define('VIEWS_DIR', ROOT.DS."views");

include_once ROOT.DS.'functions.php';
include_once ROOT.DS.'classes/'.DS.'ExecutionStatus.php';
include_once ROOT.DS.'classes/'.DS.'Options.php';
include_once ROOT.DS.'classes/'.DS.'Tasks.php';
include_once ROOT.DS.'classes/'.DS.'Task.php';
include_once ROOT.DS.'classes/'.DS.'MainView.php';
$main_view = new WPAfterInstallRoutine\MainView();
$options = new WPAfterInstallRoutine\Options();
$status = new WPAfterInstallRoutine\ExecutionStatus($main_view);

// Load and run the tasks
$tasks = new WPAfterInstallRoutine\Tasks($status, $main_view, $options);
$tasks->runTasks();

$status->endScript();