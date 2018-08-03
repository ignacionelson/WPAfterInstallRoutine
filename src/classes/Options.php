<?php
/**
 * Get options from the config file
 */

namespace WPAfterInstallRoutine;

class Options
{
    public $options;

    function __construct()
    {
        $this->options = self::getOptions();
    }

    // Prepare options
    public function getOptions()
    {
        $raw_options = file_get_contents(CONFIG_FILE);
        $this->options = json_decode($raw_options);

        return $this->options;
    }

    // Get options for a specific task
    public function getOptionsByTaskId($task_id)
    {
        if (empty($task_id))
            return false;

        if (empty($this->options->{$task_id}))
            return false;
        
        return $this->options->{$task_id};
    }
}
