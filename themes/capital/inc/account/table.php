<?php
if ( !defined('ABSPATH')) {
	die;
}
/**
 * Sql Table Class
 */
if (!class_exists('cbv_create_tables')) {
	class cbv_create_tables
	{
		public static function create_tables(){
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			
			/*creating Order table*/
			$request_tbl_name = $wpdb->prefix . 'request'; 
			if($wpdb->get_var("SHOW TABLES LIKE '$request_tbl_name'") != $request_tbl_name) {
				$b_sql = "CREATE TABLE $request_tbl_name (
					id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					sender_id BIGINT(20) UNSIGNED NOT NULL,
					request_type VARCHAR(255),
					request_details TEXT,
					file_id INT(11) DEFAULT 0,
					status VARCHAR(30) DEFAULT 'unread',
					receiver_id BIGINT(20) UNSIGNED NOT NULL,
					created_at datetime
					) $charset_collate; ";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $b_sql );
			}

			/*creating Order table*/
			$conversation_tbl_name = $wpdb->prefix . 'conversation'; 
			if($wpdb->get_var("SHOW TABLES LIKE '$conversation_tbl_name'") != $conversation_tbl_name) {
				$b_sql = "CREATE TABLE $conversation_tbl_name (
					id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					sender_id BIGINT(20) UNSIGNED NOT NULL,
					message MEDIUMTEXT,
					status VARCHAR(30) DEFAULT 'unread',
					receiver_id BIGINT(20) UNSIGNED NOT NULL,
					created_at datetime
					) $charset_collate; ";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $b_sql );
			}
		}
	}
}
