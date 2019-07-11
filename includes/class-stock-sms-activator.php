<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Stock_Sms
 * @subpackage Stock_Sms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Stock_Sms
 * @subpackage Stock_Sms/includes
 * @author     Your Name <email@example.com>
 */
class Stock_Sms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		/*********************
		* Add Customer Role
		*/
		add_role( 'customer', __('Customer'), array( 'read' => true) );

		//Database global variables
		global $wpdb;
		$package_table = $wpdb->prefix."package";
		$subscription_table = $wpdb->prefix."subscription";
		$tips_table = $wpdb->prefix."tips";
		$users_table = $wpdb->prefix."users";

		if ( $wpdb->get_var("SHOW TABLES LIKE '$package_table'") != $package_table ) {	
			//start package table
			$package_sql = "CREATE TABLE $package_table ( 
				`package_id` BIGINT(20) AUTO_INCREMENT,
				`package_name` TEXT(30) NOT NULL,
				`package_description` TEXT(200) NOT NULL,
				`package_duration` INT(2) NOT NULL,
				`duration_uom` VARCHAR(10) DEFAULT 'DAY' NOT NULL,
				`package_price` INT(5) NOT NULL,
				`price_uom` VARCHAR(10) DEFAULT 'INR' NOT NULL,
				PRIMARY KEY  (`package_id`) 
			) $charset_collate;";
			require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
			dbDelta( $package_sql );
			//execute query
		}else{}
		if ( $wpdb->get_var("SHOW TABLES LIKE '$subscription_table'") != $subscription_table ) {
			//start subscription table
			$subscription_sql = "CREATE TABLE $subscription_table ( 
				`subscription_id` BIGINT(20) AUTO_INCREMENT,
				`user_id` BIGINT(20) UNSIGNED NOT NULL,
				`package_id` BIGINT(20) NOT NULL,
				`subscription_timeperiod` INT(2) NOT NULL,
				`timeperiod_uom` VARCHAR(10) DEFAULT 'DAY' NOT NULL,
				PRIMARY KEY  (`subscription_id`),
				FOREIGN KEY (`user_id`) REFERENCES $users_table(`ID`),
				FOREIGN KEY (`package_id`) REFERENCES $package_table(`package_id`) 
			)$charset_collate;";
			require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
			dbDelta( $subscription_sql );
			// execute query
		}else{}
		if ( $wpdb->get_var("SHOW TABLES LIKE '$tips_table'") != $tips_table ) {
			//start subscription table
			$tips_sql = "CREATE TABLE $tips_table ( 
				`tip_id` BIGINT(20) AUTO_INCREMENT,
				`stock_name` TEXT(30) NOT NULL,
				`stock_qty` TEXT(10) NOT NULL,
				`entry_point` TEXT(10) NOT NULL,
				`entry_timestamp` TEXT(30) NOT NULL,
				`exit_point` TEXT(10),
				`exit_timestamp` TEXT(30),
				PRIMARY KEY  (`tip_id`)
			)$charset_collate;";
			require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
			dbDelta( $tips_sql );
			// execute query
		}else{}

	}
	
}
