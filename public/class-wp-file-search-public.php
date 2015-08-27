<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://tessera.gr
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/public
 * @author     Antonis Balasas <antoniom@tessera.gr>
 */
class Wp_File_Search_Public {

    const OPTIONS_KEY = "file_search";

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_File_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_File_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-file-search-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_File_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_File_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-file-search-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function posts_search($search) {

		global $wpdb;

        $options = get_option(self::OPTIONS_KEY);
        $search_type = $options['search_type'];

		$search_terms = get_query_var('search_terms');
		if ( empty( $search_terms )) {
			return $search;
		}
		
        if ($search_type == 'attached') {
		    $inject = "($wpdb->posts.ID IN (
							    SELECT $wpdb->posts.post_parent 
							    FROM $wpdb->posts 
							    INNER JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) 
							    WHERE $wpdb->postmeta.meta_key = '_doc_content' AND 
							    (1 = 0 ";

		    foreach ( $search_terms as $term ) {
			    $like = '%' . $wpdb->esc_like( $term ) . '%';
			    $inject .= $wpdb->prepare( "OR ($wpdb->postmeta.meta_value LIKE %s)", $like );
		    }
		
		    $inject .= "))) OR ";
		    $search = substr_replace($search, $inject, 6, 0);
        }

		return $search;

	}

}
