<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/ellak-monades-aristeias/wp-file-search
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/includes
 * @author     Antonis Balasas <abalasas@gmail.com>, Anna Damtsa <andamtsa@gmail.com>, Maria Oikonomou <oikonomou.d.maria@gmail.com>
 */
class Wp_File_Search_Deactivator {

	/**
	 * Deactivates the "parsing document" scheduled task.
	 *
	 * There is no need to run the scheduled task if the plugin is de-activated.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook('parse_documents');
	}

}
