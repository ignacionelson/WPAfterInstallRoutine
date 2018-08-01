<?php
namespace WPAfterInstallRoutine;

class Tasks
{
    private $tasks;
    
    // Construct
    function __construct(ExecutionStatus $status, $options)
    {
        $this->status = $status;
        $this->tasks = [];
        $this->options = $options;

        self::loadTasks();
    }

    protected function loadTasks()
    {
        $instances = [
            'update_wp_options' => new Tasks\UpdateOptions,
            'delete_themes' => new Tasks\DeleteDefaultThemes,
        ];

        foreach ($instances as $instance) {
            $instance->setStatusHandler($this->status);
            $instance->setTaskOptions($this->options);
            $this->addTask($instance);
        }
    }

    public function addTask($task)
    {
        $this->tasks[] = $task;
    }

    public function runTasks()
    {
        if (!empty($this->tasks)) {
            foreach ($this->tasks as $task) {
                $running_message = sprintf("Running task: %s", $task->name);
                $current_status = $this->status->addStatus($running_message);

                if (!self::executeTask($task)) {
                    $warning = sprintf("Task not completed: %d", $task->name);
                    $this->status->addWarning($warning);
                }
            }
        }
    }

    private function executeTask($task)
    {
        $method = $task->executeTask();
    }
}