<?php
namespace WPAfterInstallRoutine;

class Tasks
{
    public $view;
    public $options;

    private $tasks;
    
    // Construct
    function __construct(ExecutionStatus $status, MainView $view, Options $options)
    {
        $this->status = $status;
        $this->tasks = [];
        $this->options = $options;
        $this->view = $view;

        self::loadTasks();
    }

    /**
     * @todo make dynamic and extendable
     *
     * @return void
     */
    protected function loadTasks()
    {
        self::loadTasksFiles();

        $instances = [
            'update_wp_options' => new Tasks\UpdateOptions,
            'delete_themes' => new Tasks\DeleteDefaultThemes,
        ];

        foreach ($instances as $instance) {
//            $instance->setStatusHandler($instance->id);
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
        $task_section_title = "Running tasks";
        $task_section_content = "";

        if (!empty($this->tasks)) {
            foreach ($this->tasks as $task) {
                $task_format = "<h4>Running task: %s</h4><pre>";
                $running_message = sprintf("<p>Running task: %s</p>", $task->name);
                $current_status = $this->status->addStatus($running_message);
                $task_section_content .= $running_message;

                if (!self::executeTask($task)) {
                    $warning = sprintf("Task not completed: %s", $task->name);
                    $this->status->addWarning($warning);
                }
            }
        }
        else {
            $task_section_content .= "No tasks found";
        }

        $this->view->addSection($task_section_title, $task_section_content, "tasks");
    }

    private function loadTasksFiles()
    {
        $tasks_files = glob(__DIR__.DS.'tasks'.DS.'*.php');
        foreach ($tasks_files as $task_file) {
            include_once $task_file;
        }
    }

    private function executeTask($task)
    {
        $method = $task->executeTask();
    }
}