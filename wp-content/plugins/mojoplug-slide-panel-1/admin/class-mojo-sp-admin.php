<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://mojoplug.com
 * @since      1.0.0
 * @since      1.1.0 Panel visibility.
 *
 * @package    MojoPlug_Slide_Panel
 * @subpackage MojoPlug_Slide_Panel/admin
 */

class Mojo_SP_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $mojo_sp    The ID of this plugin.
     */
    private $mojo_sp;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $mojo_sp       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($mojo_sp, $version)
    {

        $this->mojo_sp = $mojo_sp;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->mojo_sp, plugin_dir_url(__FILE__) . 'css/mojo-sp-admin.css', array(), $this->version, 'all');
        wp_enqueue_style( 'wp-color-picker' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->mojo_sp, plugin_dir_url(__FILE__) . 'js/mojo-sp-admin.js', array('jquery'), $this->version, true);
        wp_enqueue_script( 'wp-color-picker' );
    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since    1.0.0
     */
    public function add_mojo_sp_options_page()
    {

        $this->plugin_screen_hook_suffix = add_options_page(
                'MojoPlug Slide Panel settings', 'MojoPlug Slide Panel', 'manage_options', $this->mojo_sp, array($this, 'display_options_page')
        );
    }

    /**
     * Render the options page for plugin
     *
     * @since  1.0.0
     */
    public function display_options_page()
    {
        include_once 'partials/mojo-sp-admin-display.php';
    }

    /**
     * Register all plugin options
     *
     * @since  1.0.0
     */
    public function register_mojo_sp_settings()
    {
        // register_setting($this->mojo_sp, 'mojo_sp_options', array($this, 'mojo_sp_options_validate'));
        register_setting($this->mojo_sp, 'mojo_sp_options');

        // All options are save in an array, read it once
        $options = $this->get_mojo_sp_options();

        // LEFT PANEL =========================================
        // Add a Left Panel section
        add_settings_section('mojo_sp_left_panel', __('Left Panel', 'mojo-sp'),
                array($this, 'mojo_sp_left_panel_cb'), $this->mojo_sp);

        // Show or not Panel by default
        $saved_val = $options['mojo_sp_left_panel_show'];
        add_settings_field(
                'mojo_sp_left_panel_show', __('Show panel by default', 'mojo-sp'),
                array($this, 'mojo_sp_panel_show_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_panel_show')
        );
        
        // Target element where panel will reside
        $saved_val = $options['mojo_sp_left_target'];
        add_settings_field(
                'mojo_sp_left_target', __('Target element', 'mojo-sp'),
                array($this, 'mojo_sp_target_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_target')
        );
        
        // Panel z-index
        $saved_val = $options['mojo_sp_left_zindex'];
        add_settings_field(
                'mojo_sp_left_zindex', __('Panel z-index', 'mojo-sp'),
                array($this, 'mojo_sp_zindex_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_zindex')
        );
        
        // Panel width
        $saved_val = $options['mojo_sp_left_width'];
        add_settings_field(
                'mojo_sp_left_width', __('Panel width', 'mojo-sp'),
                array($this, 'mojo_sp_width_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_width')
        );

        // Panel background color
        $saved_val = $options['mojo_sp_left_bg_color'];
        add_settings_field(
                'mojo_sp_left_bg_color', __('Panel background color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_bg_color')
        );

        // Show or not Panel Open button
        $saved_val = $options['mojo_sp_left_button_show'];
        add_settings_field(
                'mojo_sp_left_button_show', __('Button: Show', 'mojo-sp'),
                array($this, 'mojo_sp_button_show_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_button_show')
        );

        // Panel Open Icon
        $saved_val = $options['mojo_sp_left_icon_open'];
        add_settings_field(
                'mojo_sp_left_icon_open', __('Button: Icon (open panel)', 'mojo-sp'),
                array($this, 'mojo_sp_icon_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_icon_open')
        );

        // Panel Close Icon
        $saved_val = $options['mojo_sp_left_icon_close'];
        add_settings_field(
                'mojo_sp_left_icon_close', __('Button: Icon (close panel)', 'mojo-sp'),
                array($this, 'mojo_sp_icon_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_icon_close')
        );
        
        // Button icon color
        $saved_val = $options['mojo_sp_left_icon_color'];
        add_settings_field(
                'mojo_sp_left_icon_color', __('Button: Icon color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_icon_color')
        );
        
        // Button background color
        $saved_val = $options['mojo_sp_left_button_bg_color'];
        add_settings_field(
                'mojo_sp_left_button_bg_color', __('Button: Background color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_left_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_left_button_bg_color')
        );

        // RIGHT PANEL =========================================
        // Add a Right Panel section
        add_settings_section('mojo_sp_right_panel', __('Right Panel', 'mojo-sp'),
                array($this, 'mojo_sp_right_panel_cb'), $this->mojo_sp);

        // Show or not Panel by default
        $saved_val = $options['mojo_sp_right_panel_show'];
        add_settings_field(
                'mojo_sp_right_panel_show', __('Show panel by default', 'mojo-sp'),
                array($this, 'mojo_sp_panel_show_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_panel_show')
        );
        
        // Add Settings Fields for Right Panel
        $saved_val = $options['mojo_sp_right_target'];
        add_settings_field(
                'mojo_sp_right_target', __('Target element', 'mojo-sp'),
                array($this, 'mojo_sp_target_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_target')
        );

        // Panel z-index
        $saved_val = $options['mojo_sp_right_zindex'];
        add_settings_field(
                'mojo_sp_right_zindex', __('Panel z-index', 'mojo-sp'),
                array($this, 'mojo_sp_zindex_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_zindex')
        );
        
        // Panel width
        $saved_val = $options['mojo_sp_right_width'];
        add_settings_field(
                'mojo_sp_right_width', __('Panel width', 'mojo-sp'),
                array($this, 'mojo_sp_width_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_width')
        );
        
        // Panel background color
        $saved_val = $options['mojo_sp_right_bg_color'];
        add_settings_field(
                'mojo_sp_right_bg_color', __('Panel background color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_bg_color')
        );
        
        // Show or not Panel Open button
        $saved_val = $options['mojo_sp_right_button_show'];
        add_settings_field(
                'mojo_sp_right_button_show', __('Button: Show', 'mojo-sp'),
                array($this, 'mojo_sp_button_show_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_button_show')
        );
        
        // Panel Open Icon
        $saved_val = $options['mojo_sp_right_icon_open'];
        add_settings_field(
                'mojo_sp_right_icon_open', __('Button: Icon (open panel)', 'mojo-sp'),
                array($this, 'mojo_sp_icon_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_icon_open')
        );

        // Panel Close Icon
        $saved_val = $options['mojo_sp_right_icon_close'];
        add_settings_field(
                'mojo_sp_right_icon_close', __('Button: Icon (close panel)', 'mojo-sp'),
                array($this, 'mojo_sp_icon_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_icon_close')
        );
        
        // Button icon color
        $saved_val = $options['mojo_sp_right_icon_color'];
        add_settings_field(
                'mojo_sp_right_icon_color', __('Button: Icon color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_icon_color')
        );
        
        // Button background color
        $saved_val = $options['mojo_sp_right_button_bg_color'];
        add_settings_field(
                'mojo_sp_right_button_bg_color', __('Button: Background color', 'mojo-sp'),
                array($this, 'mojo_sp_color_cb'), $this->mojo_sp, 'mojo_sp_right_panel',
                array('value' => $saved_val, 'label_for' => 'mojo_sp_right_button_bg_color')
        );
    }
    
    /**
     * Validate the form data
     *
     * @since  1.0.0
     */
    public function mojo_sp_options_validate($input)
    {
        // Create our array for storing the validated options
        $output = array();

        // Loop through each of the incoming options
        foreach( $input as $key => $value ) {
            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$key] ) ) {
                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
            }
        }
        
        return $output;
    }

    /**
     * Get Mojo options, set defaults, if not available
     *
     * @since  1.0.0
     */
    private function get_mojo_sp_options()
    {
        $defs = include(__DIR__ . "/../includes/defaults.php");
        $changed = false;
        $options = get_option('mojo_sp_options');
        
        // Set the defaults if not exist or if blank
        // LEFT PANEL =======================
        if (!isset($options['mojo_sp_left_panel_show']))
            { $options['mojo_sp_left_panel_show'] = $defs['mojo_sp_left_panel_show']; $changed = true; };
        if ((!isset($options['mojo_sp_left_target'])) || ($options['mojo_sp_left_target'] == ''))
            { $options['mojo_sp_left_target'] = $defs['mojo_sp_left_target']; $changed = true; };
        if ((!isset($options['mojo_sp_left_zindex'])) || ($options['mojo_sp_left_zindex'] == ''))
            { $options['mojo_sp_left_zindex'] = $defs['mojo_sp_left_zindex']; $changed = true; };
        if ((!isset($options['mojo_sp_left_width'])) || ($options['mojo_sp_left_width'] == ''))
            { $options['mojo_sp_left_width'] = $defs['mojo_sp_left_width']; $changed = true; };
        if ((!isset($options['mojo_sp_left_bg_color'])) || ($options['mojo_sp_left_bg_color'] == ''))
            { $options['mojo_sp_left_bg_color'] = $defs['mojo_sp_left_bg_color']; $changed = true; };
        if (!isset($options['mojo_sp_left_button_show']))
            { $options['mojo_sp_left_button_show'] = $defs['mojo_sp_left_button_show']; $changed = true; };
        if ((!isset($options['mojo_sp_left_icon_open'])) || ($options['mojo_sp_left_icon_open'] == ''))
            { $options['mojo_sp_left_icon_open'] = $defs['mojo_sp_left_icon_open']; $changed = true; };
        if ((!isset($options['mojo_sp_left_icon_close'])) || ($options['mojo_sp_left_icon_close'] == ''))
            { $options['mojo_sp_left_icon_close'] = $defs['mojo_sp_left_icon_close']; $changed = true; };
        if ((!isset($options['mojo_sp_left_icon_color'])) || ($options['mojo_sp_left_icon_color'] == ''))
            { $options['mojo_sp_left_icon_color'] = $defs['mojo_sp_left_icon_color']; $changed = true; };
        if ((!isset($options['mojo_sp_left_button_bg_color'])) || ($options['mojo_sp_left_button_bg_color'] == ''))
            { $options['mojo_sp_left_button_bg_color'] = $defs['mojo_sp_left_button_bg_color']; $changed = true; };
            
        // LEFT PANEL =======================
        if (!isset($options['mojo_sp_right_panel_show']))
            { $options['mojo_sp_right_panel_show'] = $defs['mojo_sp_right_panel_show']; $changed = true; };
        if ((!isset($options['mojo_sp_right_target'])) || ($options['mojo_sp_right_target'] == ''))
            { $options['mojo_sp_right_target'] = $defs['mojo_sp_right_target']; $changed = true; };
        if ((!isset($options['mojo_sp_right_zindex'])) || ($options['mojo_sp_right_zindex'] == ''))
            { $options['mojo_sp_right_zindex'] = $defs['mojo_sp_right_zindex']; $changed = true; };
        if ((!isset($options['mojo_sp_right_width'])) || ($options['mojo_sp_right_width'] == ''))
            { $options['mojo_sp_right_width'] = $defs['mojo_sp_right_width']; $changed = true; };
        if ((!isset($options['mojo_sp_right_bg_color'])) || ($options['mojo_sp_right_bg_color'] == ''))
            { $options['mojo_sp_right_bg_color'] = $defs['mojo_sp_right_bg_color']; $changed = true; };
        if (!isset($options['mojo_sp_right_button_show']))
            { $options['mojo_sp_right_button_show'] = $defs['mojo_sp_right_button_show']; $changed = true; };  
        if ((!isset($options['mojo_sp_right_icon_open'])) || ($options['mojo_sp_right_icon_open'] == ''))
            { $options['mojo_sp_right_icon_open'] = $defs['mojo_sp_right_icon_open']; $changed = true; };
        if ((!isset($options['mojo_sp_right_icon_close'])) || ($options['mojo_sp_right_icon_close'] == ''))
            { $options['mojo_sp_right_icon_close'] = $defs['mojo_sp_right_icon_close']; $changed = true; };
        if ((!isset($options['mojo_sp_right_icon_color'])) || ($options['mojo_sp_right_icon_color'] == ''))
            { $options['mojo_sp_right_icon_color'] = $defs['mojo_sp_right_icon_color']; $changed = true; };
        if ((!isset($options['mojo_sp_right_button_bg_color'])) || ($options['mojo_sp_right_button_bg_color'] == ''))
            { $options['mojo_sp_right_button_bg_color'] = $defs['mojo_sp_right_button_bg_color']; $changed = true; };

        if ($changed)
        {
            update_option('mojo_sp_options', $options);
        }
        
        return $options;
    }

    /**
     * Render the text for the left panel section
     *
     * @since  1.0.0
     */
    public function mojo_sp_left_panel_cb()
    {
        echo '<p style="font-size:16px;">' . __('Link ID:', 'mojo-sp') . ' <b>mojosp-toggle-left</b></p>';
    }

    /**
     * Render the text for the right panel section
     *
     * @since  1.0.0
     */
    public function mojo_sp_right_panel_cb()
    {
        echo '<p style="font-size:16px;">' . __('Link ID:', 'mojo-sp') . ' <b>mojosp-toggle-right</b></p>';
    }

    /**
     * Render "show panel by default" checkbox
     *
     * @since  1.0.0
     */
    public function mojo_sp_panel_show_cb($args)
    {
        // For Checkbox, hidden field is needed to get either 1 or 0. Otherwise
        // there will be no entry at all for this option in the database after save if unchecked
        ?>
        <input type='hidden' name='mojo_sp_options[<?= esc_attr($args['label_for']); ?>]' value='0' />
        <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="1"
               <?= checked( 1, $args['value'], false ) ?>
               >
        <p class="description">
            Panel state when loading a page. Default: don't show.
        </p>
            <?php
    }
    
    /**
     * Render the text for the Target element section
     *
     * @since  1.0.0
     */
    public function mojo_sp_target_cb($args)
    {
        ?>
        <input type="text" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="<?= $args['value'] ?>"
               >
        <p class="description">
        <?= esc_html('Add an element id, class or tag where you want the panel to appear, e.g. "#my-section". Just ensure that the id, class or tag is unique. Default: "body".', 'mojo-sp'); ?>
        </p>
        <?php
    }
    
    /**
     * Show z-index setting
     *
     * @since  1.0.0
     */
    public function mojo_sp_zindex_cb($args)
    {
        ?>
        <input type="text" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="<?= $args['value'] ?>"
               >
        <p class="description">
        <?= esc_html('Z-index value of the panel. Leave empty to let the program choose a value.', 'mojo-sp'); ?>
        </p>
        <?php
    }
    
    /**
     * Render the text for the general section
     *
     * @since  1.0.0
     */
    public function mojo_sp_width_cb($args)
    {
        ?>
        <input type="text" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="<?= $args['value'] ?>"
               >
        <p class="description">
        <?= esc_html('Width of the panel, in pixels. Default: "240".', 'mojo-sp'); ?>
        </p>
        <?php
    }
    
    /**
     * Render "show button" checkbox
     *
     * @since  1.0.0
     */
    public function mojo_sp_button_show_cb($args)
    {
        // For Checkbox, hidden field is needed to get either 1 or 0. Otherwise
        // there will be no entry at all for this option in the database after save if unchecked
        ?>
        <input type='hidden' name='mojo_sp_options[<?= esc_attr($args['label_for']); ?>]' value='0' />
        <input type="checkbox" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="1"
               <?= checked( 1, $args['value'], false ) ?>
               >
        <p class="description">
            Check if you want to show a side button for opening and closing the panel
        </p>
            <?php
    }

    /**
     * Render the text for the right panel section
     *
     * @since  1.0.0
     */
    public function mojo_sp_color_cb($args)
    {
        ?>
        <input class="color-field" type="text" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="<?= $args['value'] ?>"
               >
            <?php
    }
    
    /**
     * Render the text for the right panel section
     *
     * @since  1.0.0
     */
    public function mojo_sp_icon_cb($args)
    {
        ?>
        <input type="text" id="<?= esc_attr($args['label_for']); ?>"
               name="mojo_sp_options[<?= esc_attr($args['label_for']); ?>]"
               value="<?= $args['value'] ?>"
               >
        <p class="description">
            <a href="https://developer.wordpress.org/resource/dashicons" target="_blank">Click here</a> to find available icon codes
        </p>
            <?php
    }
    
    /**
     * Create sidebars for the panels
     *
     * @since    1.0.0
     */
    public function widget_sidebars_init()
    {
        register_sidebar(array(
            'name' => __('MojoPlug Slide Panel - Left'),
            'id' => 'mojo-sp-left',
            'description' => __('Drop your widgets here'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => __('MojoPlug Slide Panel - Right'),
            'id' => 'mojo-sp-right',
            'description' => __('Drop your widgets here'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}
