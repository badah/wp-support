<?php

namespace StudioVisual\Support;

use StudioVisual\Support\Contracts\TemplateInterface;

class Shortcode implements TemplateInterface
{
    public $name;
    public $data;

    public function __construct($name, $data)
    {
        $this->name = $name;
        $this->data = $data;
        $this->register();
    }

    public function register()
    {
        add_shortcode($this->name, array($this, 'build'));
    }

    public function getTemplatePath()
    {
        return PLUGIN_ROOT_PATH . 'app/Partials/Shortcodes/'. $this->name . '.php';
    }

    public function build($atts, $content = null)
    {
        ob_start();
        include $this->getTemplatePath();
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function render()
    {
        echo do_shortcode("[{$this->name}]");
    }
}
