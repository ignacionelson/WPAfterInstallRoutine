<?php
namespace WPAfterInstallRoutine\Tasks;
use WPAfterInstallRoutine\Options;

abstract class Task
{
    // id, used to relate the tasks with the options on the config file
    public $id;

    // Name to show during status updates and messages
    public $name;

    // Options gotten from the config file
    protected $task_options;

    function __construct()
    {
        $this->task_options = [];
    }

    public function setStatusHandler($handler)
    {
        $this->status = $handler;
    }

    // Get options
    public function setTaskOptions(Options $options)
    {
        $this->task_options = $options->getOptionsByTaskId($this->id);
    }

    /**
     * If the task is present on the config file, it can be executed
     *
     * @return bool
     */
    protected function canExecuteTask()
    {
        if (!$this->task_options)
            return false;

        return true;
    }
}