<?php
namespace YoBro\Admin;

class YoBro_Admin_Menu {

	public function __construct() {
		add_action('admin_menu', array($this, 'yo_bro_register_menu'), 9);
	}

	public function yo_bro_register_menu() {
		add_menu_page(
			$page_title 	= esc_html__( 'Yo Bro', 'yobro' ),
			$menu_title 	= esc_html__( 'Yo Bro', 'yobro' ),
			$capability 	= 'manage_options',
			$menu_slug 		= 'load_yo_bro_settings',
			$function 		=  array( $this , 'yo_bro_menu_render'),
			$icon_url 		= 'dashicons-screenoptions'
		);
		add_submenu_page(
			$parent_slug = 'load_yo_bro_settings',
			$page_title = esc_html__( 'Syatem Status', 'yobro' ),
			$menu_title = esc_html__( 'Syatem Status', 'yobro' ),
			$capability = 'manage_options',
			$menu_slug = 'yobro_system_status',
			$function = array( $this, 'yobro_system_status' )
		);
	}

	public function yo_bro_menu_render() {
		if ( !current_user_can( 'manage_options' ) )  {
      wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'yobro' ) );
    }
		include_once( YOBRO_DIR. '/admin/templates/yobro-settings.php');
	}

	public function yobro_system_status() {
		if ( !current_user_can( 'manage_options' ) )  {
      wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'yobro' ) );
    }
		include_once( YOBRO_DIR. '/admin/templates/system-status.php');
	}
}
