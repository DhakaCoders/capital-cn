<?php


namespace YoBro\App;

/**
* Class YoBro_Frontend_Scripts
*/
class YoBro_Frontend_Scripts{

	/**
	* Add enqueue scripts and stylesheets
	*
	* @hooks
	*/
	public function __construct()
	{
		add_action('wp_enqueue_scripts' , array( $this , 'yobro_load_all_scripts' ));
		add_action('wp_enqueue_scripts' , array( $this , 'yobro_load_all_stylesheets' ));
		add_action('admin_enqueue_scripts' , array( $this , 'yobro_admin_scripts' ));
		add_action('init' , array( $this , 'yobro_basic_load' ));
	}

	public function yobro_basic_load(){
		add_image_size( 'user-mini', 150, 150 );
	}

	public function yobro_admin_scripts()
	{
		wp_register_style( 'yobro-admin-settings', YOBRO_CSS.'yobro-admin-settings.css', array(), false, 'all' );
		wp_enqueue_style( 'yobro-admin-settings' );

		wp_register_style( 'plan-url-copy-css', YOBRO_CSS.'plan-url-copy.css', array(), false, 'all' );
		wp_enqueue_style( 'plan-url-copy-css' );
		wp_register_script( 'highlight-pack-js',YOBRO_VEN.'highlight.pack.min.js', array('jquery'), $ver = true, true);
    wp_enqueue_script( 'highlight-pack-js' );
		wp_register_script( 'clipboardjs','//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js', array('jquery'), $ver = true, true);
    wp_enqueue_script( 'clipboardjs' );
    wp_register_script( 'plan-url-copy-js', YOBRO_VEN.'plan-url-copy.js', array('jquery'), false, true );
    wp_enqueue_script( 'plan-url-copy-js');
	}

	/**
	* @stylesheets
	*/
	public function yobro_load_all_stylesheets(){

		wp_register_style( 'font-for-body','//fonts.googleapis.com/css?family=Droid+Serif' , array(), false, 'all' );
		wp_enqueue_style( 'font-for-body' );

		wp_register_style( 'font-for-new','//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' , array(), false, 'all' );
			wp_enqueue_style( 'font-for-new' );

			wp_register_style( 'swal-css',YOBRO_CSS.'swal.css', array(), false, 'all' );
			wp_enqueue_style( 'swal-css' );

			wp_register_style( 'yobro-bundle-front-two',YOBRO_CSS_COMPILED.'yobro-bundle-front-two.css', array(), false, 'all' );
			wp_enqueue_style( 'yobro-bundle-front-two' );
			wp_register_style( 'yobro-bundle-front',YOBRO_CSS_COMPILED.'yobro-bundle-front.css', array(), false, 'all' );
			wp_enqueue_style( 'yobro-bundle-front' );

			wp_register_style( 'font-awesome',YOBRO_CSS.'font-awesome.css', array(), false, 'all' );
			wp_enqueue_style( 'font-awesome' );

			// wp_register_style( 'jquery-ui-css', 'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), false, 'all' );
			// wp_enqueue_style( 'jquery-ui-css' );

			// wp_register_style( 'bootstrap-switch', YOBRO_CSS.'bootstrap-switch.css', array(), false, 'all' );
			// wp_enqueue_style( 'bootstrap-switch' );

			// wp_register_style( 'bootstrap', YOBRO_CSS.'bootstrap.css', array(), false, 'all' );
			// wp_enqueue_style( 'bootstrap' );

			wp_register_style( 'uc-main', YOBRO_CSS.'styles.css', array(), false, 'all' );
			wp_enqueue_style( 'uc-main' );

		}

		/**
		*
		* @scripts
		*/
		public function yobro_load_all_scripts(){
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			global $post;
			global $has_yobro_shortcode;
			wp_register_script( 'yobro-variables', YOBRO_VEN. 'yobro-variables.js', array('jquery', 'underscore'), $ver = false, true );
			// wp_enqueue_script( 'yobro-variables');
			$query_var = get_query_var('console', '');
			$query_var_user = get_query_var('user', '');
			if ( is_plugin_active( 'bbpress/bbpress.php' ) ) {
			  $is_bbpress_activated = bbp_is_single_user();
			}
			if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
				global $bp;
			  $is_buddypress_activated = isset($bp->displayed_user->id) ? $bp->displayed_user->id : '';
			}
			// if($query_var == 'yes' || $query_var_user != 'yes' || isset($post) && (strpos($post->post_content, '[yobro_chatbox') !== false || strpos($post->post_content, '[yobro_chat_notification') !== false || strpos($post->post_content, '[yobro_chat_new_message') !== false) || (isset($is_bbpress_activated) and $is_bbpress_activated != '') || (isset($is_buddypress_activated) && $is_buddypress_activated != '') || $has_yobro_shortcode == true){
				// $yobro_scripts = json_decode(file_get_contents( YOBRO_DIR . "/resource/frontend-assets.json"),true);
				// wp_register_script( 'app-frontend-vendor', YOBRO_JS_COMPILED. $yobro_scripts['vendor']['js'] , array('jquery', 'underscore'), $ver = false, true);
				// wp_enqueue_script( 'app-frontend-vendor' );
				// wp_register_script( 'app-frontend', YOBRO_JS_COMPILED. $yobro_scripts['yobro_frontend']['js'], array('jquery', 'underscore'), $ver = false, true );
				// wp_enqueue_script( 'app-frontend');
				if ((isset($is_buddypress_activated) && $is_buddypress_activated != '') || $query_var == 'yes' || $query_var_user != '' || (isset($is_bbpress_activated) && $is_bbpress_activated != '')) {
					yobro_localize_scripts();
					$users = get_all_user_info();
					wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'false'));
				}
			// }
		}


		// public function localize_scripts(){
		//
		// 	$all_images =	get_posts(array(
		// 		'author'         => get_current_user_id(),
		// 		'post_status'    => 'any',
		// 		'post_type'      => 'attachment',
		// 		'posts_per_page' => -1
		// 	));
		// 	$all_user_images = array();
		//
		// 	foreach ($all_images as $img )  {
		// 		$all_user_images[] = array(
		// 			'id' => $img->ID,
		// 			'url' => $img->guid
		// 		);
		// 	}
		//
		// 	wp_localize_script( 'app-frontend', 'API', array(
		// 		'nonce' => wp_create_nonce( 'yobro' ),
		// 		'ajaxurl' => admin_url('admin-ajax.php'),
		// 		'all_images' => $all_user_images,
		// 	));
		//
		// 	wp_localize_script( 'app-frontend','PROFILE', array(
		// 		'data' => get_users_profile_data( get_current_user_id() )
		// 	));
		// 	$yobro_settings = get_option('yo_bro_settings', true);
		// 	$assets = isset($yobro_settings['files_enable']) ? $yobro_settings['files_enable'] : 'disable';
		// 	$max_file_size = isset($yobro_settings['max_file_size']) ? $yobro_settings['max_file_size'] : '5000';
		// 	$Max_num_of_files = isset($yobro_settings['max_number_of_files']) ? $yobro_settings['max_number_of_files'] : '10';
		// 	$multiple_files = isset($yobro_settings['multiple_files_enable']) ? $yobro_settings['multiple_files_enable'] : 'enable';
		// 	$chat_page_url = isset($yobro_settings['chat_page_url']) ? $yobro_settings['chat_page_url'] : '';
		// 	$chat_notification_number = isset($yobro_settings['chat_notification_number']) ? $yobro_settings['chat_notification_number'] : '5';
		// 	$chat_button_name = isset($yobro_settings['chat_button_name']) ? $yobro_settings['chat_button_name'] : 'Chat';
		// 	$number_of_messages = isset($yobro_settings['number_of_messages']) ? $yobro_settings['number_of_messages'] : 30;
		// 	wp_localize_script( 'app-frontend','INBOX', array(
		// 		'_WEBPACK_PUBLIC_PATH_' => YOBRO_JS_COMPILED,
		// 		'conversations' => get_users_all_conversation( get_current_user_id() ),
		// 		'owner_id' => get_current_user_id(),
		// 		// 'all_users' => get_all_user_info(),
		// 		'assets' => array(
		// 			'enable_assets' => $assets,
		// 			'max_file_size' => $max_file_size,
		// 			'max_num_of_files' => $Max_num_of_files,
		// 			'multiple_files' => $multiple_files,
		// 		),
		// 		'redirect_chat_url' => $chat_page_url,
		// 		'chat_notification_number' => $chat_notification_number,
		// 		'chat_button_name' => $chat_button_name,
		// 		'number_of_messages' => $number_of_messages
		// 	));
		// }
	}
