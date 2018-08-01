<?php
namespace WPAfterInstallRoutine\Tasks;
use WPAfterInstallRoutine\Tasks\Task;

class DeleteDefaultThemes extends Task {
    public $id;
    public $name;

    function __construct()
    {
        $this->id = "delete_themes";
        $this->name = "Delete default themes";
    }

    public function executeTask()
    {
        //$this->status->addStatus("Running task " . $this->id);
    }
}