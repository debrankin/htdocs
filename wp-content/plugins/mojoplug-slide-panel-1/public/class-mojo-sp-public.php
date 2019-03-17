<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 * @since      1.1.0 Panel visibility.
 *
 * @package    Mojo_SP
 * @subpackage Mojo_SP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mojo_SP
 * @subpackage Mojo_SP/public
 * @author     Your Name <email@example.com>
 */
class Mojo_SP_Public
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
     * @param      string    $mojo_sp       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($mojo_sp, $version)
    {

        $this->mojo_sp = $mojo_sp;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * An instance of this class should be passed to the run() function
         * defined in Mojo_SP_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mojo_SP_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->mojo_sp, plugin_dir_url(__FILE__) . 'css/mojo-sp-public.css', array(), $this->version, 'all');
        wp_enqueue_style($this->mojo_sp.'-style', plugin_dir_url(__FILE__) . '../style.css', array(), $this->version, 'all');
        wp_enqueue_style( 'dashicons' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     * @since    1.1.0 Added panel visibility options
     */
    public function enqueue_scripts()
    {

        /**
         * An instance of this class should be passed to the run() function
         * defined in Mojo_SP_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mojo_SP_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->mojo_sp, plugin_dir_url(__FILE__) . 'js/mojo-sp-public.js', array('jquery'), $this->version, true);
        
        // READ the settings data and make available for Javascript
        $defs = include(__DIR__ . "/../includes/defaults.php");
        $options = get_option('mojo_sp_options');
        $scriptData = array(
            'leftPanelShow' => isset($options['mojo_sp_left_panel_show']) ? $options['mojo_sp_left_panel_show'] : $defs['mojo_sp_left_panel_show'],
            'leftTarget' => isset($options['mojo_sp_left_target']) ? $options['mojo_sp_left_target'] : $defs['mojo_sp_left_target'],
            'leftZindex' => isset($options['mojo_sp_left_zindex']) ? $options['mojo_sp_left_zindex'] : $defs['mojo_sp_left_zindex'],
            'leftWidth' => isset($options['mojo_sp_left_width']) ? $options['mojo_sp_left_width'] : $defs['mojo_sp_left_width'],
            'leftBgColor' => isset($options['mojo_sp_left_bg_color']) ? $options['mojo_sp_left_bg_color'] : $defs['mojo_sp_left_bg_color'],
            'leftButtonShow' => isset($options['mojo_sp_left_button_show']) ? $options['mojo_sp_left_button_show'] : $defs['mojo_sp_left_button_show'],
            'leftIconOpen' => isset($options['mojo_sp_left_icon_open']) ? $options['mojo_sp_left_icon_open'] : $defs['mojo_sp_left_icon_open'],
            'leftIconClose' => isset($options['mojo_sp_left_icon_close']) ? $options['mojo_sp_left_icon_close'] : $defs['mojo_sp_left_icon_close'],
            'leftIconColor' => isset($options['mojo_sp_left_icon_color']) ? $options['mojo_sp_left_icon_color'] : $defs['mojo_sp_left_icon_color'],
            'leftButtonBgColor' => isset($options['mojo_sp_left_button_bg_color']) ? $options['mojo_sp_left_button_bg_color'] : $defs['mojo_sp_left_button_bg_color'],
            'rightPanelShow' => isset($options['mojo_sp_right_panel_show']) ? $options['mojo_sp_right_panel_show'] : $defs['mojo_sp_right_panel_show'],
            'rightTarget' => isset($options['mojo_sp_right_target']) ? $options['mojo_sp_right_target'] : $defs['mojo_sp_right_target'],
            'rightWidth' => isset($options['mojo_sp_right_width']) ? $options['mojo_sp_right_width'] : $defs['mojo_sp_right_width'],
            'rightZindex' => isset($options['mojo_sp_right_zindex']) ? $options['mojo_sp_right_zindex'] : $defs['mojo_sp_right_zindex'],
            'rightBgColor' => isset($options['mojo_sp_right_bg_color']) ? $options['mojo_sp_right_bg_color'] : $defs['mojo_sp_right_bg_color'],
            'rightButtonShow' => isset($options['mojo_sp_right_button_show']) ? $options['mojo_sp_right_button_show'] : $defs['mojo_sp_right_button_show'],
            'rightIconOpen' => isset($options['mojo_sp_right_icon_open']) ? $options['mojo_sp_right_icon_open'] : $defs['mojo_sp_right_icon_open'],
            'rightIconClose' => isset($options['mojo_sp_right_icon_close']) ? $options['mojo_sp_right_icon_close'] : $defs['mojo_sp_right_icon_close'],
            'rightIconColor' => isset($options['mojo_sp_right_icon_color']) ? $options['mojo_sp_right_icon_color'] : $defs['mojo_sp_right_icon_color'],
            'rightButtonBgColor' => isset($options['mojo_sp_right_button_bg_color']) ? $options['mojo_sp_right_button_bg_color'] : $defs['mojo_sp_right_button_bg_color'],
        );

        wp_localize_script($this->mojo_sp, 'mojospOptions', $scriptData);
    }

    /**
     * Add html code to the page for the panels
     *
     * @since    1.0.0
     */
    public function create_panels_html()
    {
        if (is_active_sidebar('mojo-sp-left')) :
            echo '      <div id="mojo-sp-left-wrap">
                            <div id="mojo-sp-left" class="mojo-sp">
                                <div class="mojosp-widget-area">';
                dynamic_sidebar('mojo-sp-left');
                echo '          </div><!-- .widget-area -->
                            </div>
                            <button id="mojo-sp-left-button" class="mojo-sp-button">
                                <span class="dashicons"></span>
                            </button>
                        </div>';

        endif;
        
        if (is_active_sidebar('mojo-sp-right')) :
            echo '      <div id="mojo-sp-right-wrap">
                            <div id="mojo-sp-right" class="mojo-sp">
                                <div class="mojosp-widget-area">';
                dynamic_sidebar('mojo-sp-right');
                echo '          </div><!-- .widget-area -->
                            </div>
                            <button id="mojo-sp-right-button" class="mojo-sp-button">
                                <span class="dashicons"></span>
                            </button>
                        </div>';

        endif;
    }

}
