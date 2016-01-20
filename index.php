<?php
	/*
	Plugin Name: CB Questionnaire
	Plugin URI: http://tronnet.me
	Version: 0.9.8
	Author: Tronnet DevOps
	Author URI: http://tronnet.me
	*/
	class CBQuestionnaire {
		/**
		 * A reference to an instance of this class.
		 */
		private static $instance;
		/**
		 * The array of templates that this plugin tracks.
		 */
		protected $templates;
		/**
		 * Returns an instance of this class. 
		 */
		public static function get_instance() {
			if( null == self::$instance ) {
				self::$instance = new CBQuestionnaire();
			} 
			return self::$instance;
		} 
		/**
		 * Initializes the plugin by setting filters and administration functions.
		 */
		private function __construct() {
			$this->templates = array();
			// Add a filter to the attributes metabox to inject template into the cache.
			add_filter(
						'page_attributes_dropdown_pages_args',
						 array( $this, 'register_project_templates' ) 
					);
			// Add a filter to the save post to inject out template into the page cache
			add_filter(
						'wp_insert_post_data', 
						array( $this, 'register_project_templates' ) 
					);
			// Add a filter to the template include to determine if the page has our 
					// template assigned and return it's path
			add_filter(
						'template_include', 
						array( $this, 'view_project_template') 
					);
			// Add your templates to this array.
			$this->templates = array(
				'questionnaire-template.php'     => 'CB Questionnaire'
			);
			

		}
		
		public function save_data($key, $data){
			if ( get_option( $key ) !== false ) {
			    update_option( $key, $data );
			} else {
			    add_option( $key, $data );
			}
			
			return get_option( $key );
		}
		
		public function get_data($key){
			return get_option( $key );
		}
		
		
		/**
		 * 
		 */
		function load_scripts() {
			if (is_singular('cb_questionnaire')){
				wp_enqueue_style( 'foundation', 'http://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/css/foundation.min.css' );
				wp_enqueue_style( 'foundation-icons', 'http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css' );
				wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
				wp_enqueue_style( 'cbquestionnaire-main-css', plugins_url( '/styles/main.css' , __FILE__ ) );
			
				wp_enqueue_script( 'foundation', 'http://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/js/foundation.min.js', array('jquery'), '6.0.1', true );
				wp_enqueue_script( 'dataTables', 'http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js', array('jquery'), '1.10.7', true );
				wp_enqueue_script( 'foundation-dataTables', 'http://cdn.datatables.net/plug-ins/1.10.7/integration/foundation/dataTables.foundation.js', array('foundation', 'dataTables'), '1.10.7', true );
				wp_enqueue_script( 'cbquestionnaire-main-js', plugins_url( '/js/main.js' , __FILE__ ) , array('jquery', 'foundation'), '1.0.0', true );
			}
		}
		
		public function create_posttype(){
		    register_post_type( 'cb_questionnaire',
				array(
					'labels' => array(
						'name' => __( 'Questionnaires' ),
						'singular_name' => __( 'Questionnaire' )
					),
					'public' => true,
					// 'has_archive' => true,
					'rewrite' => array('slug' => 'questionnaires'),
				)
		    );
		}
		
		public function myplugin_activate() {
			
			//create a variable to specify the details of page
			$post = array(
				'post_type'		=> 'cb_questionnaire',
				'post_content'	=> '',
				'post_title'	=> __( 'Credit Questionnaire' ),
				'post_name'		=> 'credit-questionnaire',
				'post_status'	=> 'publish'
			);
			
			$new_post_id = wp_insert_post( $post ); // creates page
			
			update_post_meta( $new_post_id, '_wp_page_template', 'questionnaire-template.php' );
		}
		
		public function myplugin_deactivate() {
			$Posts = get_posts(array(
				'post_type' => 'cb_questionnaire'
			));
			
			foreach($Posts as $Post){
				wp_delete_post($Post->ID);
			}
		}
		
		/**
		 * Adds our template to the pages cache in order to trick WordPress
		 * into thinking the template file exists where it doens't really exist.
		 *
		 */
		public function register_project_templates( $atts ) {
			// Create the key used for the themes cache
			$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
			// Retrieve the cache list. 
					// If it doesn't exist, or it's empty prepare an array
					$templates = wp_get_theme()->get_page_templates();
			if ( empty( $templates ) ) {
				$templates = array();
			} 
			// New cache, therefore remove the old one
			wp_cache_delete( $cache_key , 'themes');
			// Now add our template to the list of templates by merging our templates
			// with the existing templates array from the cache.
			$templates = array_merge( $templates, $this->templates );
			// Add the modified cache to allow WordPress to pick it up for listing
			// available templates
			wp_cache_add( $cache_key, $templates, 'themes', 1800 );
			return $atts;
		} 
		/**
		 * Checks if the template is assigned to the page
		 */
		public function view_project_template( $template ) {
			global $post;
			if (!isset($this->templates[get_post_meta( 
						$post->ID, '_wp_page_template', true 
					)] ) ) {
					
				return $template;
						
			} 
			$file = plugin_dir_path(__FILE__). get_post_meta( 
						$post->ID, '_wp_page_template', true 
					);
				
			// Just to be safe, we check if the file exist first
			if( file_exists( $file ) ) {
				return $file;
			} 
					else { echo $file; }
			return $template;
		}
		
		/**
		 * Custom User Field
		 */
		
		// create custom plugin settings menu

		function cb_questionnaire_create_menu() {

			//create new top-level menu
			add_menu_page('Questionaire Settings', 'Questionaire', 'administrator', __FILE__, array( 'CBQuestionnaire', 'cb_questionnaire_settings_page' ) );

			//call register settings function
			add_action( 'admin_init', array( 'CBQuestionnaire', 'register_cb_questionnaire_settings' ) );
		}


		function register_cb_questionnaire_settings() {
			//register our settings
			register_setting( 'cb-questionnaire-settings-group', 'json_data' );
		}

		function cb_questionnaire_settings_page() {
			wp_enqueue_style( 'foundation', 'http://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/css/foundation.min.css' );
			wp_enqueue_style( 'foundation-icons', 'http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css' );
			wp_enqueue_style( 'font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
			wp_enqueue_style( 'spectrum', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css' );
			wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css' );
			wp_enqueue_style( 'introjs', 'https://cdnjs.cloudflare.com/ajax/libs/intro.js/1.1.1/introjs.min.css' );
			wp_enqueue_style( 'cbquestionnaire-admin-css', plugins_url( '/styles/admin.css' , __FILE__ ) );
		
			
			wp_enqueue_script( 'foundation', 'http://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/js/foundation.min.js', array('jquery'), '6.0.1', true );
			wp_enqueue_script( 'dataTables', 'http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js', array('jquery'), '1.10.7', true );
			wp_enqueue_script( 'foundation-dataTables', 'http://cdn.datatables.net/plug-ins/1.10.7/integration/foundation/dataTables.foundation.js', array('foundation', 'dataTables'), '1.10.7', true );
			wp_enqueue_script( 'select2', 'http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.js', array('foundation', 'dataTables'), '4.0.1', true );
			wp_enqueue_script( 'spectrum', 'https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js', array('foundation'), '1.8.0', true );
			wp_enqueue_script( 'introjs', 'https://cdnjs.cloudflare.com/ajax/libs/intro.js/1.1.1/intro.min.js', array('foundation'), '1.1.1', true );
			wp_enqueue_script( 'sortable', 'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js', array('foundation'), '1.4.2', true );
			wp_enqueue_script( 'cbquestionnaire-admin-js', plugins_url( '/js/admin.js' , __FILE__ ) , array('jquery', 'foundation'), '1.0.0', true );
			
			wp_enqueue_media();
			
			$plugin_uri = plugins_url( '/' , __FILE__ );
			
			require_once( dirname( __FILE__ ) . '/templates/admin-panel.php');
		}
		
	} 
	add_action( 'plugins_loaded', array( 'CBQuestionnaire', 'get_instance' ) );
	add_action('admin_menu', array( 'CBQuestionnaire', 'cb_questionnaire_create_menu' ) );
	
	
    register_activation_hook( __FILE__, array( 'CBQuestionnaire', 'myplugin_activate' ) );
    register_deactivation_hook( __FILE__, array( 'CBQuestionnaire', 'myplugin_deactivate' ) );
	
	add_action( 'init', array( 'CBQuestionnaire', 'create_posttype' ) );
	add_action( 'wp_enqueue_scripts', array( 'CBQuestionnaire', 'load_scripts' ), 999 );
	
