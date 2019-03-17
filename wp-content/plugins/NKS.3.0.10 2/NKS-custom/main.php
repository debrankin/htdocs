<?php
/*
Plugin Name: Ninja Kick: Sliding Panel
Plugin URI: http://sidebar.looks-awesome.com/
Description: Push/Sliding Panel on every page of your site.
Version: 3.0.10
Author: Looks Awesome
Author URI: http://looks-awesome.com/
License: Commercial License
Text Domain: nks-custom
Domain Path: /lang
*/

$plugin = array(
    'name' => 'NKS-custom',
    'label' => 'Ninja Kick: Sliding Panel',
    'prefix' => 'nks',
    'demo_site' => 'http://sidebar.looks-awesome.com',
    'version' => '3.0.10',
    'require_php' => '5.3.0',
    'require_ext' => array('zip'),
    'namespace' => 'NKS',
    'base' => '',
    'base_url' => '',
    'mode' => ''
);

require __DIR__ . '/includes/Activator.php';

$activator = new LA_NKS_App_Activator($plugin);
add_action( 'admin_init', array( 'LA_NKS_App_Activator', 'check' ) );
if(!LA_NKS_App_Activator::compatible()){
    return;
}

register_activation_hook(__FILE__, 'LA_NKS_App_Activator::activate');

if (!defined('NKS_VERSION_KEY')) {
    define('NKS_VERSION_KEY', 'nks_version');
}

if (!defined('NKS_VERSION_NUM')) {
    define('NKS_VERSION_NUM', '3.0.10');
}

add_option(NKS_VERSION_KEY, NKS_VERSION_NUM);

global $nks_cc_options;
global $nks_init;

load_plugin_textdomain('nks-custom', false, basename(dirname(__FILE__)).'/lang');

include_once(dirname(__FILE__).'/settings.php');

if(!class_exists('LA_IconManager')){
    include_once(dirname(__FILE__).'/includes/vendor/looks_awesome/icon_manager/IconManager.php');
}

$nks_la_icon_manager = LA_IconManager::getInstance();
register_activation_hook(__FILE__, array($nks_la_icon_manager, 'addDefaultFonts'));
register_deactivation_hook(__FILE__, 'LA_IconManager::deleteOption');

$env = null;
if (file_exists(plugin_dir_path(__FILE__).'env.json')) {
    $env = json_decode(file_get_contents(plugin_dir_path(__FILE__).'env.json'), true);
    if (!defined('NKS_MODE')) {
        $mode = $env['mode'] ? $env['mode'] : 'dev';
        define('NKS_MODE', $mode);
    }
}

add_action('wp_enqueue_scripts', 'nks_cc_scripts');
add_action('admin_menu', 'nks_cc_menu');

function nks_cc_menu()
{
    global $nks_admin_page;

    $nks_admin_page = add_options_page(
        'NK: Sliding Panel',
        '<span style="display: inline-block;border-left:3px solid #B64B6D; padding-left:3px;position: relative;left: -6px;">NK: Sliding Panel</span>',
        'manage_options',
        'nks-custom-options',
        'nks_cc_page'
    );
}

/**
 * Settings page in the WP Admin
 */
function nks_cc_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'nks-custom'));
    }
    if (NKS_MODE === 'dev') {
        wp_enqueue_script('tinycolor', plugins_url('/js/tinycolor.js', __FILE__), array('jquery'));
        wp_enqueue_script('nks_cc_colorpickersliders', plugins_url('/js/jquery.colorpickersliders.js', __FILE__));
        wp_enqueue_script('nks_cc_admin', plugins_url('/js/admin.js', __FILE__));
        wp_enqueue_script('awesome-ajax', plugins_url('/js/vendor/looks_awesome/common/ajax.js', __FILE__));
        wp_enqueue_script('awesome-util', plugins_url('/js/vendor/looks_awesome/common/util.js', __FILE__));
        $handle = 'awesome-ajax';

        wp_enqueue_style('colorpickersliders-ui-css', plugins_url('/css/jquery.colorpickersliders.css', __FILE__));
        wp_enqueue_style('nks_cc_admin_css', plugins_url('/css/admin.css', __FILE__), array(), NKS_VERSION_NUM, 'all');
    } else {
        wp_enqueue_script('nks_cc_admin', plugins_url('/js/admin.min.js', __FILE__), array(), NKS_VERSION_NUM);
        $handle = 'nks_cc_admin';
        wp_enqueue_style('nks_cc_admin', plugins_url('/css/admin.min.css', __FILE__), array(), NKS_VERSION_NUM, 'all');
    }

    $nks_la_icon_manager = LA_IconManager::getInstance();
    $nks_la_icon_manager->enqueueAdminScripts();

    wp_enqueue_media();
    wp_enqueue_script('wp-ajax-response');
    wp_enqueue_style(
        'open-sans-font',
        '//fonts.googleapis.com/css?family=Open+Sans:300normal,400normal,400italic,600normal,600italic&subset=all'
    );

    wp_localize_script(
        $handle,
        'laim_localize',
        array(
            'ajax_nonce' => wp_create_nonce('laim'),
            'ajaxurl' => admin_url('admin-ajax.php'),
        )
    );
    include_once(dirname(__FILE__).'/options-page.php');
}


add_filter('plugin_action_links_NKS-custom/main.php', 'nks_cc_plugin_action_links', 10, 1);

function nks_cc_plugin_action_links($links)
{
    $settings_page = add_query_arg(array('page' => 'nks-custom-options'), admin_url('options-general.php'));
    $settings_link = '<a href="'.esc_url($settings_page).'">'.__('Settings', 'nks-custom').'</a>';
    array_unshift($links, $settings_link);

    return $links;
}

add_action('wp_head', 'nks_cc_main_html', 10000);

function nks_is_mobile()
{
    return preg_match(
        "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
        $_SERVER["HTTP_USER_AGENT"]
    );
}

function nks_cc_main_html()
{
    global $nks_init;
    $options = nks_cc_get_options();

    if ($options['nks_cc_test_mode'] === 'yes' && !current_user_can('manage_options')) {
        return;
    }
    if (!isset($nks_init)) {
        return;
    }
    include_once(dirname(__FILE__).'/nks-custom.php');
}

function nks_cc_scripts()
{
    global $nks_init;

    $options = nks_cc_get_options();
    if ($options['nks_cc_test_mode'] === 'yes' && !current_user_can('manage_options')) {
        return;
    }

    $isMobile = nks_is_mobile();
    $indicators = (object)array();
    for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {
        $tab = 'tab_'.$i;
        $indicators->$tab = nks_show_tab(json_decode($options['nks_cc_display_'.$i]), $isMobile);
    }

    $options['indicators'] = $indicators;

    foreach ($indicators as $indicator) {
        if ($indicator) {
            $nks_init = true;
        }
    }

    if (!isset($nks_init)) {
        return;
    }

    $nks_init = $indicators;

    if (NKS_MODE === 'dev') {
        wp_enqueue_script('nks_cc_public', plugins_url('/js/nks-custom.js', __FILE__), array('jquery'), NKS_VERSION_NUM);
        wp_enqueue_style('nks_cc_styles', plugins_url('/css/nks-custom.css', __FILE__));
        wp_enqueue_style('la-icon-manager', plugins_url('/includes/vendor/looks_awesome/icon_manager/css/style.css', __FILE__));
    }else{
        wp_enqueue_script('nks_cc_public', plugins_url('/js/public.min.js', __FILE__), array('jquery'), NKS_VERSION_NUM);
        wp_enqueue_style('nks_cc_styles', plugins_url('/css/public.min.css', __FILE__));
    }

    $nks_la_icon_manager = LA_IconManager::getInstance();
    $nks_la_icon_manager->enqueuePublicScripts();

    $sidebar_type = $options['nks_cc_sidebar_type'];
    $sidebar_pos = $options['nks_cc_sidebar_pos'];
    if (NKS_MODE === 'demo') {
        $sidebar_type = isset($_GET['nks_sidebar_type']) ? esc_html($_GET['nks_sidebar_type']) : $sidebar_type;
        $sidebar_pos = isset($_GET['nks_sidebar_pos']) ? esc_html($_GET['nks_sidebar_pos']) : $sidebar_type;
    }

    wp_localize_script(
        'nks_cc_public',
        'NKS_CC_Opts',
        array(
            'test_mode' => $options['nks_cc_test_mode'],
            'sidebar_type' => $sidebar_type,
            'sidebar_pos' => $sidebar_pos,
            'width' => $options['nks_cc_sidebar_width'],
            'gaps' => $options['nks_cc_sidebar_gaps'],
            'base_color' => $options['nks_cc_base_color'],
            'fade_content' => $options['nks_cc_fade_content'],
            'label_top' => $options['nks_cc_label_top'],
            'label_top_mob' => $options['nks_cc_label_top_mob'],
            'label_size' => $options['nks_cc_label_size'],
            'label_vis' => $options['nks_cc_label_vis'],
            'label_invert' => $options['nks_cc_label_invert'],
            'label_no_anim' => $options['nks_cc_label_no_anim'],
            'label_scroll_selector' => $options['nks_cc_label_vis_selector'],
            'selectors' => $options['nks_cc_selectors'],
            'bg' => $options['nks_cc_image_bg'],
            'path' => plugins_url('/img/', __FILE__),
        )
    );
}


function register_nks_widget_area()
{
    $options = nks_cc_get_options();

    if (function_exists('register_sidebar')) {

        for ($i = 1; $i <= $options['nks_cc_tabs']; $i++) {
            register_sidebar(
                array(
                    'name' => 'Ninja Kick Tab '.$i,
                    'id' => 'nks_area_'.$i,
                    'description' => __('Widgets in this area will be shown in Ninja Kick Panel', 'nks-custom'),
                    'before_widget' => '<div class="widget">',
                    'after_widget' => '</div>',
                    'before_title' => '<h1 class="title">',
                    'after_title' => '</h1>',
                )
            );
        }
    }
}

function nks_get_lang_id($id, $type = 'page')
{
    if (function_exists('icl_object_id')) {
        $id = icl_object_id($id, $type, true);
    }

    return $id;
}

function nks_show_tab($opt, $isMobile)
{
    $post_id = get_queried_object_id();

    if (is_home()) {
        $show = isset($opt->location->wp_pages->home);
        if (!$show && $post_id) {
            $show = isset($opt->location->pages->$post_id);
        }

        // check if blog page is front page too
        if (!$show && is_front_page() /*&& isset($opt['page-front'])*/) {
            $show = isset($opt->location->wp_pages->front);
        }

    } else {
        if (is_front_page()) {
            $show = isset($opt->location->wp_pages->front);
            if (!$show && $post_id) {
                $show = isset($opt->location->pages->$post_id);
            }
        } else {
            if (is_category()) {
                $catid = get_query_var('cat');
                $show = isset($opt->location->cats->$catid);
            } else {
                if (is_archive()) {
                    $show = isset($opt->location->wp_pages->archive);
                } else {
                    if (is_single()) {
                        $type = get_post_type();
                        $show = isset($opt->location->wp_pages->single);

                        if (!$show && $type != 'page' && $type != 'post') {
                            $show = isset($opt->location->cposts->$type);
                        }

                        if (!$show) {
                            $cats = get_the_category();
                            foreach ($cats as $cat) {
                                if ($show) {
                                    break;
                                }
                                $c_id = nks_get_lang_id($cat->cat_ID, 'category');
                                $show = isset($opt->location->cats->$c_id);
                                unset($c_id);
                                unset($cat);
                            }
                        }

                    } else {
                        if (is_404()) {
                            $show = isset($opt->location->wp_pages->forbidden);

                        } else {
                            if (is_search()) {
                                $show = isset($opt->location->wp_pages->search);
                            } else {
                                if ($post_id) {
                                    $show = isset($opt->location->pages->$post_id);
                                } else {
                                    $show = false;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    if ($post_id && !$show && isset($opt->location->ids) && !empty($opt->location->ids)) {
        $other_ids = $opt->location->ids;
        foreach ($other_ids as $other_id) {
            if ($post_id == (int)$other_id) {
                $show = true;
            }
        }
    }

    if (!$show && defined('ICL_LANGUAGE_CODE')) {
        // check for WPML widgets
        $lang = ICL_LANGUAGE_CODE;
        $show = isset($opt->location->langs->$lang);
    }


    if (!isset($show)) {
        $show = false;
    }

    if ($show && $opt->rule->exclude || !$show && $opt->rule->include) {
        $show = false;
    } else {
        $show = true;
    }

    $user_ID = is_user_logged_in();

    if (($opt->user->loggedout && $user_ID) || ($opt->user->loggedin && !$user_ID)) {
        $show = false;
    }

    if ($opt->mobile->no && $isMobile) {
        $show = false;
    }

    return $show;
}

function nks_debug_to_console($data)
{
    if (is_array($data) || is_object($data)) {
        echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
    } else {
        echo("<script>console.log('PHP: ".$data."');</script>");
    }
}

add_action('wp_loaded', 'register_nks_widget_area');
