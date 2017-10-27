<?php

namespace Badah\WpSupport\Components;

use Badah\WpSupport\Helpers\String;

class AjaxRequest
{
    protected $script_name;
    protected $script_file_name;
    protected $script_object;
    protected $script_dependencies;
    protected $scope;
    protected $action;
    protected $data;

    public function __construct($script_file_name, $action, $data, $scope = 'global')
    {
        $this->setup($script_file_name, $action, $data, $scope);
        $this->registerScripts();
        $this->registerHandle();
    }

    protected function setup($script_file_name, $action, $data, $scope)
    {
        $this->script_file_name = $script_file_name;
        $this->scope = $scope;
        $this->script_name = Core::PLUGIN_NAME . '-' . $this->script_file_name;
        $this->action = $action;
        $this->data = $data;
    }

    protected function registerScripts()
    {
        if (!$this->isAdmin()) {
            $this->script_object = String::toCamelCase($this->script_file_name);
            $this->script_dependencies = ['jquery'];
            add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        } else {
            add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        }
    }

    public function enqueueScripts()
    {
        wp_enqueue_script(
            $this->script_name,
            PLUGIN_ROOT_URL . ASSETS_DIR . "ajax-{$this->script_file_name}.js",
            $this->script_dependencies,
            Core::VERSION,
            true
        );

        if (!$this->isAdmin()) {
            wp_localize_script(
                $this->script_name,
                $this->script_object,
                ['ajaxurl' => admin_url('admin-ajax.php')]
            );
        }
    }

    public function registerHandle()
    {
        $obj = String::toSnakeCase($this->script_file_name);
        add_action("wp_ajax_{$obj}", [$this, 'handle']);

        if (!$this->isAdmin()) {
            add_action("wp_ajax_no_priv_{$obj}", [$this, 'handle']);
        }
    }

    public function handle()
    {
        $response = is_callable($this->action) ? call_user_func($this->action, $this->data) : false;
        wp_send_json($response);
        exit;
    }

    private function isAdmin()
    {
        return 'admin' === $this->scope;
    }
}
