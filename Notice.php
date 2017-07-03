<?php

namespace StudioVisual\Support;

class Notice
{
    private $message;
    private $type;
    private $is_dismissible;

    /**
     * Notice constructor.
     * @param $message string
     * @param $type string Os parametros podem ser: error, warning, success, or info.
     * @param $is_dismissible boolean
     */
    public function __construct($message, $type, $is_dismissible = true)
    {
        $this->message = $message;
        $this->type = $type;
        $this->is_dismissible = $is_dismissible;

        add_action('admin_notices', [$this, 'render']);
    }

    public function render()
    {
        $dismissible = ($this->is_dismissible) ? 'is-dismissible' : ''; ?>
        <div class="notice notice-<?php echo $this->type ?> <?php echo $dismissible ?>">
            <p><?php echo $this->message ?></p>
        </div> <?php
    }

    public static function display($message, $type = 'info', $is_dismissible = true)
    {
        new self($message, $type, $is_dismissible);
    }
}