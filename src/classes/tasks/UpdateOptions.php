<?php
namespace WPAfterInstallRoutine\Tasks\Task;
use WPAfterInstallRoutine\Tasks\Task;

class UpdateOptions extends Task {

    // Construct from parent Task
    function __construct()
    {
        parent::__construct();
        
        $this->id = "update_wp_options";
        $this->name = "Update database options";
    }

    public function executeTask()
    {
        //$this->status->addStatus("Running task " . $this->id);
    }
}