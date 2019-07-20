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

	//Add New Registration Fields
	public function add_registration_fields() {
		//Get and set any values already sent
		$user_mobile = ( isset( $_POST['user_mobile'] ) ) ? $_POST['user_mobile'] : '';
		?>
		<p>
			<label for="user_mobile"><?php _e( 'Mobile', 'stock-sms' ) ?><br />
			<input type="text" name="user_mobile" id="user_mobile" class="input" value="<?php echo esc_attr( stripslashes( $user_mobile ) ); ?>" /></label>
		</p>
		<?php
	}

	public function sanitize_registration_fields( $errors, $sanitized_user_login, $user_email ) {
		if ( empty( $_POST['user_mobile'] ) ) {
			$errors->add( 'user_mobile_error', __( '<strong>ERROR</strong>: Please enter your mobile number.', 'stock-sms' ) );
		}elseif( strlen( trim($_POST['user_mobile']) ) != 10 ){
			$errors->add( 'user_mobile_error', __( '<strong>ERROR</strong>: Invalid mobile number.', 'stock-sms' ) );
		}
		return $errors;
	}

	public function registration_save( $user_id ) {
		if ( ! empty( $_POST['user_mobile'] ) ){
			update_user_meta($user_id, 'user_mobile', $_POST['user_mobile']);
		}	
	}

	// show/edit user mobile field in profile
	public function user_profile_fields( $user ) {
	?>
		<table class="form-table">
			<tr>
				<th>
					<label for="user_mobile"><?php esc_html_e( 'Mobile Number' ); ?></label>
				</th>
				<td>
					<input type="text" name="user_mobile" id="user_mobile" value="<?php echo esc_attr( get_the_author_meta( 'user_mobile', $user->ID ) ); ?>" class="regular-text" disabled/>
					<br><span class="description"><?php esc_html_e( 'Your Mobile Number.', 'stock-sms' ); ?></span>
				</td>
			</tr>
		</table>
	<?php
	}
	// save user mobile field in profile
	public function save_user_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) { 
			return false; 
		}
		if( !empty( $_POST['user_mobile'] ) ){
			update_user_meta( $user_id, 'user_mobile', $_POST['user_mobile'] );	
		}
	}
	// Stock SMS Plugin 
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
		$subscription_table = $wpdb->prefix."subscription";
		$user_table = $wpdb->prefix."users";

		$stock_name= $_POST['stock_name'];
		$stock_qty= $_POST['stock_qty'];
		$entry_point= $_POST['entry_point'];
		$entry_time= $_POST['entry_time'];
		$stop_loss= $_POST['stop_loss'];

		$wpdb->insert( 
			$tips_table, 
			array( 
				'stock_name'		=> $stock_name, 
				'stock_qty' 		=> $stock_qty,
				'entry_point'		=> $entry_point,
				'entry_timestamp'	=> $entry_time,
				'stop_loss'			=> $stop_loss
			), 
			array( 
				'%s', 
				'%d',
				'%s',
				'%s',
				'%s'
			) 
		);
		//message to send
		$message = 'Stock Name:'.$stock_name.', Stock Qty:'.$stock_qty.', Entry Point:'.$entry_point.', Stop Loss:'.$stop_loss;
		// Initial Data for curl operation
		$api_key= 'WDW1H5NKPJ4YY4DV0NEHGX2NRT69XVOJ';
		$secret_key= '2LB06GR4SCSPZHNY';
		$use_type = 'stage';
		$sender_id = '';

		// get customer who has subscribed to package
		$customers = $wpdb->get_results( 
			"SELECT 
				* 
			FROM 
				$user_table,
				$subscription_table
			WHERE
				$user_table.ID=$subscription_table.user_id",
			OBJECT  
		);
		
		foreach ($customers as $customer) {
			$user_id = $customer->ID;
			$user_mobile = get_user_meta($user_id, 'user_mobile', true);
			if( $customer->subscription_timeperiod != 0 ){
				$url="https://www.way2sms.com/api/v1/sendCampaign";
				$message = urlencode( $message );// urlencode your message
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
				curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$api_key&secret=$secret_key&usetype=$use_type&phone=$user_mobile&senderid=$sender_id&message=$message");// post data
				// query parameter values must be given without squarebrackets.
				// Optional Authentication:
				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($curl);
				curl_close($curl);
				echo $result;
			}
		}
		wp_die();
	}
	public function add_exit_tip(){
		global $wpdb;
		$tips_table = $wpdb->prefix."tips";
		$subscription_table = $wpdb->prefix."subscription";
		$user_table = $wpdb->prefix."users";

		$tip_id= $_POST['tip_id'];
		$exit_point= $_POST['exit_point'];
		$exit_time= $_POST['exit_time'];

		$tip = $wpdb->get_results( 
			"SELECT 
				* 
			FROM 
				$tips_table
			WHERE
				$tips_table.tip_id=$tip_id",
			OBJECT  
		);
		//Update Tip exit point and time
		$stock_name = $tip[0]->stock_name;
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
		// get customer who has subscribed to package
		$customers = $wpdb->get_results( 
			"SELECT 
				* 
			FROM 
				$user_table,
				$subscription_table
			WHERE
				$user_table.ID=$subscription_table.user_id",
			OBJECT  
		);
		
		//message to send
		$message = 'Stock Name:'.$stock_name.', Exit Point:'.$exit_point;
		// Initial Data for curl operation
		$api_key= 'WDW1H5NKPJ4YY4DV0NEHGX2NRT69XVOJ';
		$secret_key= '2LB06GR4SCSPZHNY';
		$use_type = 'stage';
		$sender_id = '';
		foreach ($customers as $customer) {
			$user_id = $customer->ID;
			$user_mobile = get_user_meta($user_id, 'user_mobile', true);
			if( $customer->subscription_timeperiod != 0 ){
				$url="https://www.way2sms.com/api/v1/sendCampaign";
				$message = urlencode( $message );// urlencode your message
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
				curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$api_key&secret=$secret_key&usetype=$use_type&phone=$user_mobile&senderid=$sender_id&message=$message");// post data
				// query parameter values must be given without squarebrackets.
				// Optional Authentication:
				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($curl);
				curl_close($curl);
				echo $result;
			}
		}
		wp_die();
	}

	public function add_extra_tip(){
		$extra_tip= $_POST['extra_tip'];
		//message to send
		$message = $extra_tip;
		// Initial Data for curl operation
		$api_key= 'WDW1H5NKPJ4YY4DV0NEHGX2NRT69XVOJ';
		$secret_key= '2LB06GR4SCSPZHNY';
		$use_type = 'stage';
		$sender_id = '';

		// get customer who has subscribed to package
		$customers = $wpdb->get_results( 
			"SELECT 
				* 
			FROM 
				$user_table,
				$subscription_table
			WHERE
				$user_table.ID=$subscription_table.user_id",
			OBJECT  
		);
		
		foreach ($customers as $customer) {
			$user_id = $customer->ID;
			$user_mobile = get_user_meta($user_id, 'user_mobile', true);
			if( $customer->subscription_timeperiod != 0 ){
				$url="https://www.way2sms.com/api/v1/sendCampaign";
				$message = urlencode( $message );// urlencode your message
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
				curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$api_key&secret=$secret_key&usetype=$use_type&phone=$user_mobile&senderid=$sender_id&message=$message");// post data
				// query parameter values must be given without squarebrackets.
				// Optional Authentication:
				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($curl);
				curl_close($curl);
				echo $result;
			}
		}
		wp_die();
	}
}
