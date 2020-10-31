<?php

namespace YoBro\App;

/**
* Class YoBro_Install
*
* @author      RedQTeam
* @category    Admin
* @package     YoBro\Admin
* @version     1.0.2
* @since       1.0.0
*/

class YoBro_Install{

	public function __construct(){
		// install hooks
		register_activation_hook( YOBRO_FILE, array( &$this, 'yobro_plugin_install' ) );
	}

	/**
	* For db table
	* @return [type] [description]
	*/
	public function yobro_plugin_install(){

		// Getting started page redirect
		add_option('yobro_plugin_do_activation_redirect', true);
		add_option('yobro_page_setup', true);
		add_option('yobro_form_setup', true);
		$notices= __("Welcome to YoBro – You‘re almost ready to start :)", 'yobro');
		update_option('yobro_plugin_deferred_admin_notices', $notices);
		global $wpdb;
		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}
		$schema = "CREATE TABLE {$wpdb->prefix}yobro_conversation (
			id bigint(200) NOT NULL auto_increment,
			sender bigint(200) NOT NULL,
			reciever  bigint(200) NOT NULL,
			seen tinytext NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}yobro_messages (
			id bigint(200) NOT NULL auto_increment,
			conv_id bigint(200) NOT NULL,
			attachment_id bigint(200) NULL,
			sender_id bigint(200) NOT NULL,
			reciever_id bigint(200) NOT NULL,
			message longtext NULL,
			status tinytext NULL,
			seen tinytext NULL,
			delete_status boolean DEFAULT 0 NOT NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}yobro_deleted_conversation (
			id bigint(200) NOT NULL auto_increment,
			user bigint(200) NOT NULL,
			conv_id bigint(200) NOT NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}yobro_blocked_conversation (
			id bigint(200) NOT NULL auto_increment,
			blocked_by bigint(200) NOT NULL,
			blocked_user bigint(200) NOT NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}yobro_attachments (
			id bigint(200) NOT NULL auto_increment,
			conv_id bigint(200) NULL,
			type tinytext NULL,
			size bigint(200) NULL,
			url longtext NULL,
			created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (id)
		) $collate;
		CREATE TABLE {$wpdb->prefix}yobro_logs (
			id bigint(200) NOT NULL auto_increment,
			log_details text NULL,
      created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY  (id)
		) $collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta($schema);
	}
}
