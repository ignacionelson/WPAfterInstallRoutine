<?php
/**
 * General app/script execution handler
 * 
 * @todo add system checks (memory_limit, etc)
 */

namespace WPAfterInstallRoutine;

class ExecutionStatus
{
    // Error count
    private $error_count;
    private $errors;
    private $status;
    private $warnings;

    // Construct
    function __construct()
    {
        $this->error_count = 0;
        $this->errors = [];
        $this->status = [];
        $this->warnings = [];
    }

    // Add an error to the list
    public function addError($message)
    {
        $this->errors[] = $message;
        self::increaseErrorCount();

        return $this;
    }

    // Add a general status message to the list
    public function addStatus($message)
    {
        $this->status[] = $message;
        echo self::showCurrentStatus($message);

        return $this;
    }

    // Add a warning to the list
    public function addWarning($message)
    {
        $this->warnings[] = $message;

        return $this;
    }
    
    /**
     * Runs at the end of execution
     *
     * @return void
     * @todo format output of messages
     * @todo save a .log file with errors, warnings and full status list
     * @todo email results if option is set
     * @todo SELF DELETE THE SCRIPT!
     */
    public function endScript()
    {
        echo self::showErrors();
        echo self::showWarnings();
        $this->exit_code = ($this->error_count === 0) ? 0 : 1;
        exit($this->exit_code);
    }

    // Add to the error count
    private function increaseErrorCount()
    {
        $this->error_count++;
    }

    // Display list of errors
    private function showErrors()
    {
        if (count($this->errors) > 0) {
            $return = sprintf("%d errors found. Listing: %d", count($this->errors), getDump($this->errors));
        }
        else {
            $return = "No custom errors were logged. Everything went well!";
        }

        return $return;
    }

    // Display status of current running task
    private function showCurrentStatus($message)
    {
        $return = $message;
        return $return;
    }

    // Display list of all saved statuses
    private function showAllStatus()
    {
        if (count($this->status) > 0) {
            $return = sprintf("%d errors found. Listing: %d", count($this->status), getDump($this->status));
        }
        else {
            $return = "No custom status messages were logged.";
        }

        return $return;
    }
    

    // Display list of errors
    private function showWarnings()
    {
        $return = "";

        if (count($this->warnings) > 0) {
            $return = sprintf("%d warnings found. Listing: %d", count($this->warnings), getDump($this->warnings));
        }

        return $return;
    }
}