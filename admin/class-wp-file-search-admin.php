<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://tessera.gr
 * @since      1.0.0
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_File_Search
 * @subpackage Wp_File_Search/admin
 * @author     Antonis Balasas <antoniom@tessera.gr>
 */
class Wp_File_Search_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        add_action('admin_menu', array($this, 'add_wp_file_search_option_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_wp_file_search_option_page() {
        // This page will be under "Settings"
        add_options_page(
                'Settings WP File Search', 'WP File Search', 'manage_options', 'wp-file-search-admin', array($this, 'create_admin_page')
        );
    }
    
    /*
     * Initialize options
     */ 
    public function page_init() {
        $this->options = array(
            'direct_file_control' => '',
            'read_pdf' => 'read_pdf_chk',
            'read_docx' => 'read_docx',
            'read_odt' => 'read_odt',
            'search_files' => 'search_all_files',
        );
        add_option('search_on_files_options', $this->options);
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        include( plugin_dir_path(__FILE__) . 'partials/wp-file-search-admin-display.php');
    }

    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-file-search-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-file-search-admin.js', array('jquery'), $this->version, false);
    }

}
