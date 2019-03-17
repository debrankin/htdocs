<?php
/**
 * Plugin Name:     BackUp WD
 * Plugin URI:      https://web-dorado.com/products/wordpress-backup-wd.html
 * Description:     Backup WD is an easy-to-use, fully functional backup plugin that allows to backup your website.
 * Version: 1.0.19
 * Author:          WebDorado
 * Author URI:      https://web-dorado.com
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

setlocale(LC_ALL, 'en_US.UTF-8');
define('BUWD_MAIN_FILE', plugin_basename(__FILE__));
define('BUWD_DIR', dirname(__FILE__));
define('BUWD_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('BUWD_VERSION', '1.0.18');
define('BUWD_PREFIX', 'buwd');

add_action("init", "buwd_ten_web_lib_init");
function buwd_ten_web_lib_init()
{

    if (!class_exists("TenWebLib")) {
        require_once(BUWD_DIR . '/wd/start.php');
    }


    global $buwd_plugin_options;
    $buwd_plugin_options = array(
        "prefix"                 => "buwd",
        "plugin_id"              => 71,
        "plugin_title"           => "BackUp WD",
        "plugin_wordpress_slug"  => "backup-wd",
        "plugin_dir"             => BUWD_DIR,
        "plugin_main_file"       => __FILE__,
        "description"            => '',
        "plugin_features"        => array(
            0 => array(
                "title"       => __("DIFFERENTIAL BACKUP", BUWD_PREFIX),
                "description" => __("Save time and space by choosing differential backups to save just the data that has changed since the last full backup.", BUWD_PREFIX),
                "logo"        => BUWD_URL . "/public/overview/differential-backup.svg"
            ),
            1 => array(
                "title"       => __("10WEB CLOUD", BUWD_PREFIX),
                "description" => __("Get a minimum of 10GB free 10Web cloud storage in Amazon S3. Store, access and manage your backups without a hitch.", BUWD_PREFIX),
                "logo"        => BUWD_URL . "/public/overview/tenweb-storage.svg"
            ),
            2 => array(
                "title"       => __("DASHBOARD RESTORE", BUWD_PREFIX),
                "description" => __("Restore the latest version of your website quickly and easily with just a click from your 10Web dashboard.", BUWD_PREFIX),
                "logo"        => BUWD_URL . "/public/overview/restore.svg"
            ),
        ),
        "user_guide"             => array(),
        "overview_welcome_image" => BUWD_URL . "/public/overview/icon.svg",
        "video_youtube_id"       => "",
        "plugin_wd_url"          => "",
        "plugin_wd_demo_link"    => "",
        "plugin_wd_addons_link"  => "",
        "after_subscribe"        => "admin.php?page=buwd_jobs",
        "plugin_wizard_link"     => "",
        "plugin_menu_title"      => __('Backup WD', 'buwd'),
        "plugin_menu_icon"       => BUWD_URL . '/public/images/menu_logo.png',
        "deactivate"             => true,
        "subscribe"              => true,
        "custom_post"            => "buwd_jobs",
        "menu_capability"        => "buwd_edit",
        "menu_position"          => null,
        "display_overview"       => 0
    );
    ten_web_lib_init($buwd_plugin_options);

}

if (version_compare(PHP_VERSION, '5.5.0') >= 0) {
    require_once BUWD_DIR . '/vendor/autoload.php';

    require_once(BUWD_DIR . '/includes/buwd.php');
    require_once(BUWD_DIR . '/includes/buwd-options.php');

    add_action('plugins_loaded', array('Buwd', 'get_instance'));

    require_once(BUWD_DIR . '/includes/buwd-admin.php');
    register_activation_hook(__FILE__, array('Buwd_Admin', 'activate'));
    add_action('plugins_loaded', array('Buwd_Admin', 'get_instance'));
    add_action('admin_init', array('Buwd_Admin', 'check_removed_destinations'));
    add_action('admin_notices', 'buwd_display_removed_destinations_notice');
    if (class_exists("WP_REST_Controller")) {
        require_once('buwd-rest.php');
        add_action('rest_api_init', function () {

            $rest = new BUWD_Rest();
            $rest->register_routes();
        });
    }

    //deactivation hook
    register_deactivation_hook(__FILE__, array('Buwd_Admin', 'deactivate'));
} else {
    add_action('admin_notices', 'buwd_php_version_admin_notice');
}

function buwd_php_version_admin_notice()
{
    ?>
    <div class="notice notice-error">
        <h3>Backup WD</h3>
        <p><?php _e('This version of the plugin requires PHP 5.5.0 or higher.', 'buwd'); ?></p>
        <p><?php _e('We recommend you to update PHP or ask your hosting provider to do that.', 'buwd'); ?></p>
    </div>
    <?php
}

function buwd_display_removed_destinations_notice()
{
    ;
    if (Buwd_Admin::is_buwd_page() && get_transient('buwd_has_job_with_deleted_destination')): ?>

        <div class="notice notice-error">
            <h3>Backup WD</h3>
            <p><?php _e('It seems You use one of the following destinations: ', 'buwd');
                echo implode(', ', array_values(Buwd_Admin::get_removed_destinations())); ?></p>
            <p><?php _e('You can reconfigure your jobs or downgrade your plugin to minor <a href="https://downloads.wordpress.org/plugin/backup-wd.1.0.14.zip">version</a>', 'buwd'); ?></p>
        </div>
    <?php endif;
}

function buwd_add_plugin_meta_links($meta_fields, $file)
{
    if (plugin_basename(__FILE__) == $file) {
        $plugin_url = "https://wordpress.org/support/plugin/backup-wd";
        $prefix = 'buwd';
        $meta_fields[] = "<a href='" . $plugin_url . "' target='_blank'>" . __('Support Forum', $prefix) . "</a>";
        $meta_fields[] = "<a href='" . $plugin_url . "/reviews#new-post' target='_blank' title='" . __('Rate', $prefix) . "'>
            <i class='wdi-rate-stars'>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
            . "</i></a>";

        $stars_color = "#ffb900";

        echo "<style>"
            . ".wdi-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
            . ".wdi-rate-stars svg{fill:" . $stars_color . ";}"
            . ".wdi-rate-stars svg:hover{fill:" . $stars_color . "}"
            . ".wdi-rate-stars svg:hover ~ svg{fill:none;}"
            . "</style>";
    }

    return $meta_fields;
}

add_filter("plugin_row_meta", 'buwd_add_plugin_meta_links', 10, 2);
