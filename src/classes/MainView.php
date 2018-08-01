<?php
/**
 * HTML output for browsers
 * 
 * @todo add system checks (memory_limit, etc)
 */

namespace WPAfterInstallRoutine;
use  Tidy;

class MainView
{
    public $result;

    // Browser or command line
    private $is_cli;

    // Main content strings accumulator
    private $main_content;

    // Main view template
    private $template;
    private $template_section;

    function __construct()
    {
        $this->template = file_get_contents("./views/template.php");
        $this->template = self::setValue("{script_name}", "WordPress: After install routine", $this->template);

        $this->template_section = file_get_contents("./views/section.php");

        $this->main_content = "";
    }

    public function addSection($title, $contents = [], $class = "")
    {
        if (empty($contents) && empty($title))
            return;
        
        $this->new_section = $this->template_section;

        $this->new_section = self::setValue("{class}", $class, $this->new_section);
        $this->new_section = self::setValue("{title}", $title, $this->new_section);
        $this->new_section = self::setValue("{content}", $contents, $this->new_section);

        self::addToMainContent($this->new_section);
    }

    public function addToMainContent($contents = [])
    {
        if (empty($contents))
            return;

        if (!is_array($contents))
        {
            $contents = [$contents];
        }

        foreach ($contents as $content) {
            $this->main_content .= $content ."\n";
        }
    }

    public function render()
    {
        $this->template = self::setValue("{sections}", $this->main_content, $this->template);

        return $this->template;
    }

    private function setValue($template_tag, $value, $where)
    {
        $this->result = str_replace($template_tag, $value, $where);

        return $this->result;
    }
}
