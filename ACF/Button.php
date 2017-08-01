<?php

namespace StudioVisual\Support\ACF;

class Button extends \acf_field
{
    /**
     * This function will setup the field type data
     *
     * @since   5.0.0
     * @param n/a $settings n/a.
     */
    public function __construct()
    {
        // Name (string) Single word, no spaces. Underscores allowed.
        $this->name = 'option_button';

        // Label (string) Multiple words, can include spaces, visible when selecting a field type.
        $this->label = __('Botão Simples', Core::PLUGIN_NAME);

        // Category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME.
        $this->category = 'layout';

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
     * @todo   eliminar label por outras vias que não CSS.
     */
    function render_field($field)
    {
        $html = "<style>.acf-field-option-button .acf-label{display:none}</style><input type=\"button\" value=\"{$field['label']}\" class=\"button button-primary button-large\"
                id=\"{$field['_name']}\" name=\"{$field['_name']}\">";
        echo $html;
    }
}
