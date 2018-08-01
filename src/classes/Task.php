<?php
namespace WPAfterInstallRoutine\Tasks;

abstract class Task
{
    // id, used to relate the tasks with the options on the config file
    public $id;

    // Name to show during status updates and messages
    public $name;

    // Required functions from each task
    abstract protected function executeTask();

    private function __construct()
    {        
    }

    public function setStatusHandler($handler)
    {
        $this->status = $handler;
    }

    // Get options
    public function setTaskOptions($options)
    {
        // Set the options only if they are available on the source JSON file
        if (!empty($options->{$this->id})) {
            $task_options = $options->{$this->id};
        }

        return $this;
    }
}