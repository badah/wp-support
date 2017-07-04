<?php

namespace StudioVisual\Support\Components;

use StudioVisual\Support\Contracts\TemplateInterface;

class Shortcode implements TemplateInterface
{
    protected $name;
    protected $data;
    protected $path;

    public function __construct($name, $data, $path = 'front/shortcodes/')
    {
        $this->name = $name;
        $this->data = $data;
        $this->path = $path;
        $this->register();
    }

    public function register()
    {
        add_shortcode($this->name, array($this, 'build'));
    }

    public function getTemplatePath()
    {
        return plugin_dir_path( dirname( __FILE__ ) ) . $this->path . $this->name . '.php';
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
