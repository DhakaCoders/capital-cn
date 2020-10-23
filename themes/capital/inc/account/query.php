<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Cbv_Db_Query')) {
	/**
	 * 
	 */
	class Cbv_Db_Query
	{

		public static function create($table, $data = array()){
			global $wpdb;
			$insertB = $wpdb->insert("$table", $data);
			return ($insertB) ? true : false;
		}	
		public static function update($table, $data = array(), $where = array()){
			global $wpdb;
			$udpatetB = $wpdb->update("$table", $data, $where);
			return ($udpatetB) ? true : false;
		}
		public static function delete($table, $where = array()){
			global $wpdb;
			$deletetB = $wpdb->delete("$table", $where);
			return ($deletetB) ? true : false;
		}
		public static function get_all($table, $where = array()){
			global $wpdb;
			$getalltB = $wpdb->get_results("$table", $where);
			return ($getalltB) ? true : false;
		}
	}//end class
}