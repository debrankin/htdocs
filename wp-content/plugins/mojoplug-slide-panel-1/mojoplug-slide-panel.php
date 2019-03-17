<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://mojoplug.com
 * @since             1.0.0
 * @since             1.0.1 Workaround for iPhone Apache bug.
 * @since             1.1.0 New feature: show or hide panel by default.
 * @since             1.1.1 Fix compatibility issue with Visual Composer
 * @package           MojoPlug_Slide_Panel
 *
 * @wordpress-plugin
 * Plugin Name:       MojoPlug Slide Panel
 * Plugin URI:        http://mojoplug.com
 * Description:       Lightweight, fast and smooth slide panels for your favorite widgets. Clean interface, customizable appearance, mobile friendly.
 * Version:           1.1.1
 * Author:            Qumos
 * Author URI:        http://qumos.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mojo-sp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mojo-sp-activator.php
 */
function activate_mojo_sp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mojo-sp-activator.php';
	Mojo_SP_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mojo-sp-deactivator.php
 */
function deactivate_mojo_sp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mojo-sp-deactivator.php';
	Mojo_SP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mojo_sp' );
register_deactivation_hook( __FILE__, 'deactivate_mojo_sp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mojo-sp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mojo_sp() {

	$plugin = new Mojo_SP();
	$plugin->run();

}
run_mojo_sp();
