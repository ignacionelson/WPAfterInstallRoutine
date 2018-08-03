<?php
/**
 * General app/script execution handler
 * 
 * @todo add system checks (memory_limit, etc)
 */

namespace WPAfterInstallRoutine;
use WPAfterInstallRoutine\MainView;

class ExecutionStatus
{
    public $view;
    public $options;

    // Error count
    private $error_count;
    private $errors;
    private $status;
    private $warnings;

    // Construct
    function __construct(MainView $view)
    {
        $this->error_count = 0;
        $this->errors = [];
        $this->status = [];
        $this->warnings = [];
        $this->view = $view;

        ob_start();

        self::getRequiredFiles();
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
        //echo self::showCurrentStatus($message);

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
     */
    public function endScript()
    {
        $end_section_title = "Results";
        $end_section_content = self::showErrors() . self::showWarnings();
        $this->view->addSection($end_section_title, $end_section_content, "end");

        echo $this->view->Render();
        
        $contents = ob_get_contents();
        ob_get_clean();
        
        echo $contents;
        
        $this->exit_code = ($this->error_count === 0) ? 0 : 1;
        exit($this->exit_code);
    }

    // wp-load.php and config.json
    private function getRequiredFiles()
    {
        // Start by including the main WP file
        if (!file_exists(WP_MAIN_FILE))
        {
            $e = sprintf("The main WP file could not be loaded from %s", WP_MAIN_FILE);
            self::addError($e);
        }

        // Get options from the configuration file
        if (!file_exists(CONFIG_FILE)) {
            $e = sprintf("The configuration file (%s) does not exist", CONFIG_FILE);
            self::addError($e);
        }

        // End if the required files are not found
        if (self::hasErrors()) {
            self::endScript();
        }
    }
    
    // Add to the error count
    private function increaseErrorCount()
    {
        $this->error_count++;
    }

    private function makeList($elements)
    {
        if ( is_cli() ) {
            $return = "";
            foreach ($elements as $el) {
                $return .= "-" . $el . PHP_EOL;
            }
        }
        else {
            $return = "<ul>";
            foreach ($elements as $el) {
                $return .= "<li>" . $el . "</li>";
            }
            $return .= "</ul>";
        }

        return $return;
    }

    public function hasErrors()
    {
        if (count($this->errors) > 0) {
            return true;
        }

        return false;
    }

    // Display list of errors
    private function showErrors()
    {
        if (count($this->errors) > 0) {
            $return = sprintf("%d errors found. \n %s", count($this->errors), self::makeList($this->errors));
        }
        else {
            $return = "No custom errors were logged. \n";
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
            $return = sprintf("%d status updates found. \n %s", count($this->status), self::makeList($this->status));
        }
        else {
            $return = "No custom status updates were logged. \n";
        }

        return $return;
    }
    

    // Display list of errors
    private function showWarnings()
    {
        $return = "";

        if (count($this->warnings) > 0) {
            $return = sprintf("%d warnings found. \n %s", count($this->warnings), self::makeList($this->warnings));
        }

        return $return;
    }
}