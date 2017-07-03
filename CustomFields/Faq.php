<?php

namespace StudioVisual\Support\CustomFields;

use StudioVisual\Dotz\Core\Core;
use StudioVisual\Support\View;

class Faq extends \acf_field
{
    /**
     * This function will setup the field type data
     *
     * @since   5.0.0
     * @param n/a $settings n/a.
     */
    public function __construct($data)
    {
        // Name (string) Single word, no spaces. Underscores allowed.
        $this->name = 'componente_faq';

        // Label (string) Multiple words, can include spaces, visible when selecting a field type.
        $this->label = __('FAQ', Core::PLUGIN_NAME);

        // Category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME.
        $this->category = 'Componentes';

        // Defaults (array) Array of default settings which are merged into the field object.
        // These are used later in settings.
        $this->defaults = [];

        // L10n (array) Array of strings that are used in JavaScript.
        // This allows JS strings to be translated in PHP and loaded via.
        $this->l10n = [];

        // Settings (array) Store plugin settings (url, path, version) as a reference for later use with assets.
        $this->settings = [
            'url' => plugin_dir_url(__FILE__),
            'path' => plugin_dir_path(__FILE__)
        ];

        // Do not delete!
        parent::__construct();

        $this->data = $data;
    }

    /**
     * Create extra settings for your field. These are visible when editing a field.
     *
     * @param  Array $field The $field being edited.
     * @return void
     */
    function render_field_settings($field)
    {
        //
    }

    /**
     * Create the HTML interface for your field
     *
     * @param  array $field The $field being edited.
     * @return void
     */
    function render_field($field)
    {
        new View('faq', $this->data);
    }
}
