<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/ellak-monades-aristeias/wp-file-search
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/includes
 * @author    Antonis Balasas <abalasas@gmail.com>, Anna Damtsa <andamtsa@gmail.com>, Maria Oikonomou <oikonomou.d.maria@gmail.com>
 */
class Wp_File_Search_Activator {

	/**
	 * Activates the "parsing document" scheduled task.
	 *
	 * Sets up a cron job to check (every hour), parse and save the contents of new documents.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Apply a custom interval
		add_filter( 'cron_schedules', function ( $schedules ) {
			// add a 'weekly' schedule to the existing set
			$schedules['everyminute'] = array(
				'interval' => 60,
				'display' => __('Every Minute')
			);
			return $schedules;
		} ); 

		// trigger the function for the specified interval
		// Schedule an action if it's not already scheduled
		if ( ! wp_next_scheduled( 'document_lookup' ) ) {
    		wp_schedule_event( time(), 'hourly', 'document_lookup' );
		} 
	}

}
