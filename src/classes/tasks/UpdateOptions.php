<?php
namespace WPAfterInstallRoutine\Tasks;
use WPAfterInstallRoutine\Tasks\Task;

class UpdateOptions extends Task {
    public $id;
    public $name;

    function __construct()
    {
        $this->id = "update_wp_options";
        $this->name = "Update database options";
    }

    public function executeTask()
    {
        //$this->status->addStatus("Running task " . $this->id);
    }
}