<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/ellak-monades-aristeias/wp-file-search
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/includes
 * @author     Antonis Balasas <abalasas@gmail.com>, Anna Damtsa <andamtsa@gmail.com>, Maria Oikonomou <oikonomou.d.maria@gmail.com>
 */
class Wp_File_Search {

    const OPTIONS_LAST_UPDATE_KEY = "wp_file_search_wfs_last_update_key";
    const OPTIONS_KEY = "wp_file_search_wfs_file_search";
    const OPT_DIRECT_PARSING = "wp_file_search_wfs_direct_parsing";
    const OPT_FILE_TYPES = "wp_file_search_wfs_file_types";
    const OPT_SEARCH_TYPE = "wp_file_search_wfs_search_type";

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_File_Search_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-file-search';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->define_system_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_File_Search_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_File_Search_i18n. Defines internationalization functionality.
	 * - Wp_File_Search_Admin. Defines all hooks for the admin area.
	 * - Wp_File_Search_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-file-search-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-file-search-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-file-search-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-file-search-public.php';

		/**
		 * Add classes required for document parsing.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/parsers/parser.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/parsers/docx.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/parsers/pdf.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/parsers/odt.php';

		$this->loader = new Wp_File_Search_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_File_Search_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_File_Search_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_File_Search_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_File_Search_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_filter( 'pre_get_posts', $plugin_public, 'pre_get_posts' );
		$this->loader->add_filter( 'posts_search', $plugin_public, 'posts_search' );
		$this->loader->add_filter( 'posts_where', $plugin_public, 'posts_where' );
		$this->loader->add_filter( 'posts_request', $plugin_public, 'posts_request' );
	}

	/**
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_system_hooks() {
		$this->loader->add_action( 'document_lookup', $this, 'scheduled_document_check' );
		$this->loader->add_action( 'add_attachment', $this, 'event_driven_document_check' );

		// debug only!
		//$this->loader->add_action( 'wp_loaded', $this, 'event_driven_document_check' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_File_Search_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the unparsed documents.
	 *
	 * @since     1.0.0
	 * @return    array    The list of attachment posts who have not been parsed yet.
	 */
	private function get_unparsed_documents() {
		global $wpdb;

		$last_update = get_option(self::OPTIONS_LAST_UPDATE_KEY);
		//$last_update = '2010-10-10 10:05:00';

		$query = "SELECT 
						id, 
						post_mime_type,
						pm.meta_value as filename
					FROM 
						$wpdb->posts p
					LEFT JOIN 
						$wpdb->postmeta pm ON pm.post_id = p.id
					LEFT JOIN 
						$wpdb->postmeta pm2 ON pm2.post_id = p.id
					WHERE 
						p.post_type = 'attachment' AND
						pm.meta_key = '_wp_attached_file' AND 
						pm2.meta_id NOT IN (
							SELECT pm3.meta_id 
							FROM $wpdb->postmeta pm3
							WHERE pm3.meta_key='_doc_content' 
						)";

		// save to wp_postmeta
		$results = $wpdb->get_results($query);

		// access plugin settings
		$unparsed = array();
		foreach($results as $result) {
			$unparsed[] = array(
							'post_id' => $result->id,
							'mime_type' => $result->post_mime_type, 
							'filename' => $result->filename
						);
		}

		return $unparsed;
	}

	/**
	 * Saves documents found on postmeta table.
	 *
	 * @since     1.0.0
	 */
	private function save_doc_contents($post_id, $doc_contents) {
		add_post_meta($post_id, '_doc_content', $doc_contents, TRUE);
	}

	/**
	 * Parses each compatible document found.
	 *
	 * @param     boolean     $direct_parsing     Proceeds parsing only when this parameter and admin's choice match.
	 * @since     1.0.0
	 */
	private function parse_documents($direct_parsing_hook) {

		$options = get_option(self::OPTIONS_KEY);
        $direct_parsing_option = $options[self::OPT_DIRECT_PARSING];
        if ($direct_parsing_option !== $direct_parsing_hook) {
        	return;
        }

        $upload_dir = wp_upload_dir();
		$documents = $this->get_unparsed_documents();	
		foreach($documents as $document) {
			$filepath = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $document['filename'];

			$content = NULL;
			switch ($document['mime_type']) {
				case 'application/pdf':
					$content = PdfParser::parse($filepath);
					break;

				case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
					$content = DocxParser::parse($filepath);
					break;
				
				case 'application/vnd.oasis.opendocument.text':
					$content = OdtParser::parse($filepath);
					break;

				default:
					break;
			}
			if (!$content) {
				continue;
			}
			// add content to postmeta
			$this->save_doc_contents($document['post_id'], $content);
		}

		// update last parsing date
		update_option(self::OPTIONS_LAST_UPDATE_KEY, gmdate('Y-m-d H:i:s'));
	}

	/**
	 * Triggers document parsing when scheduled check is enabled.
	 *
	 * @since     1.0.0
	 */
	public function scheduled_document_check() {
		$this->parse_documents(FALSE);
	}

	/**
	 * Triggers document parsing when event driven check is enabled.
	 *
	 * @since     1.0.0
	 */
	public function event_driven_document_check() {
		$this->parse_documents(TRUE);	
	}

}
