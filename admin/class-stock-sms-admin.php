<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Stock_Sms
 * @subpackage Stock_Sms/admin
 * @author     Your Name <email@example.com>
 */
class Stock_Sms_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/stock-sms-admin.css', array(), $this->version, 'all' );
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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/stock-sms-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'ajax', plugin_dir_url( __FILE__ ) . 'js/stock-sms-ajax.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name.'ajax', 'ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php') ) );

	}

	public function stock_tips_pages(){
		add_menu_page( 
			'Stock Tips',
			'Stock Tips', 
			'read', 
			'stock_tips', 
			array( $this,'stock_tips_callback' ), 
			plugin_dir_url( __FILE__ ).'/images/firetips-32x32.png',
			2
		);
		add_submenu_page( 'stock_tips', 'Customer List', 'Customer List', 'manage_options', 'customer_list', array( $this,'customer_list_callback' ) );
		add_submenu_page( 'stock_tips', 'Subscription List', 'Subscription List', 'manage_options', 'subscription_list', array( $this,'subscription_list_callback' ) );
		add_submenu_page( 'stock_tips', 'Today\'s Tips', 'Today\'s Tips', 'read', 'today_tips', array( $this,'today_tips_callback' ) );
		add_submenu_page( 'stock_tips', 'Add New Tips', 'Add New Tips', 'manage_options', 'tip-new', array( $this,'tip_new_callback' ) );
	}
	function stock_tips_callback(){
		require_once( plugin_dir_path( __FILE__ ).'/partials/main-page.php' );
	}
	function customer_list_callback(){
		require_once( plugin_dir_path( __FILE__ ).'/partials/customer-list-page.php' );
	}
	function subscription_list_callback(){
		require_once( plugin_dir_path( __FILE__ ).'/partials/subscription-list-page.php' );
	}
	function today_tips_callback(){
		require_once( plugin_dir_path( __FILE__ ).'/partials/today-tips-page.php' );
	}
	function tip_new_callback(){
		require_once( plugin_dir_path( __FILE__ ).'/partials/tip-new-page.php' );
	}
	public function add_entry_tip(){
		global $wpdb;
		$tips_table = $wpdb->prefix."tips";

		$stock_name= $_POST['stock_name'];
		$stock_qty= $_POST['stock_qty'];
		$entry_point= $_POST['entry_point'];
		$entry_time= $_POST['entry_time'];

		$wpdb->insert( 
			$tips_table, 
			array( 
				'stock_name'		=> $stock_name, 
				'stock_qty' 		=> $stock_qty,
				'entry_point'		=> $entry_point,
				'entry_timestamp'	=> $entry_time
			), 
			array( 
				'%s', 
				'%d',
				'%s',
				'%s'
			) 
		);
		wp_die();
	}
	public function add_exit_tip(){
		global $wpdb;
		$tips_table = $wpdb->prefix."tips";

		$tip_id= $_POST['tip_id'];
		$exit_point= $_POST['exit_point'];
		$exit_time= $_POST['exit_time'];

		$wpdb->update( 
			$tips_table, 
			array( 
				'exit_point' 		=> $exit_point,
				'exit_timestamp' 	=> $exit_time
			), 
			array( 'tip_id' => $tip_id ), 
			array( 
				'%s',
				'%s'
			), 
			array( '%d' ) 
		);
		wp_die();
	}
}
