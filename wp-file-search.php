<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/ellak-monades-aristeias/wp-file-search
 * @since             1.0.0
 * @package           Wp_File_Search
 *
 * @wordpress-plugin
 * Plugin Name:       WP File Search
 * Plugin URI:        https://github.com/ellak-monades-aristeias/wp-file-search
 * Description:       WP File Search extends the default WP search to lookup on pdf, docx and odt files you have uploaded to the media library.
 * Version:           1.0.0
 * Author:            Antonis Balasas
 * Author URI:        https://github.com/ellak-monades-aristeias/wp-file-search
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-file-search
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-file-search-activator.php
 */
function activate_wp_file_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-file-search-activator.php';
	Wp_File_Search_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-file-search-deactivator.php
 */
function deactivate_wp_file_search() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-file-search-deactivator.php';
	Wp_File_Search_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_file_search' );
register_deactivation_hook( __FILE__, 'deactivate_wp_file_search' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-file-search.php';

/*
 * Include admin class
 */
require plugin_dir_path( __FILE__ ) . 'admin/class-wp-file-search-admin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_file_search() {

	$plugin = new Wp_File_Search();
	$plugin->run();

}
run_wp_file_search();
