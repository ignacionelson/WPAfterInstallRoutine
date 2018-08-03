<?php
namespace WPAfterInstallRoutine\Tasks;
use WPAfterInstallRoutine\Tasks\Task;

class DeleteDefaultThemes extends Task {

    // Construct from parent Task
    function __construct()
    {
        parent::__construct();
        
        $this->id = "delete_default_themes";
        $this->name = "Delete default themes";
    }

    public function executeTask()
    {   
        $themes = $this->task_options;
        foreach ($themes as $theme => $unused) {
        }
    }
}