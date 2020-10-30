<?php
add_shortcode( 'yobro_chatbox', 'yobro_chatbox' );
add_shortcode( 'yobro_chat_notification', 'yobro_chat_notification' );
add_shortcode( 'yobro_chat_new_message', 'yobro_chat_new_message' );
add_shortcode( 'bulk_message', 'bulk_message' );
add_shortcode( 'userList', 'userList' );

function yobro_chatbox($atts) {
	global $has_yobro_shortcode;
	$has_yobro_shortcode = true;
	yobro_localize_scripts();
	extract(shortcode_atts( array(
        'user_id' 					=> 'null',
				'user_display_name' => 'null',
				'user_roles'					=> 'null',
				'meta_key' 					=> 'null',
				'meta_value' 				=> 'null'
    ), $atts ));
	if ($user_roles == 'null' && $user_id == 'null' && $user_display_name == 'null' && $meta_key == 'null' && $meta_value == 'null') {
		$users = get_all_user_info();
		wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'false'));
	}
	if($user_id != 'null'){
		$users = get_single_user_info($user_id);
		create_new_conversation($user_id);
		wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'true'));
	}
	if($meta_key != 'null' && $meta_value != 'null'){
		$users = get_user_info_by_meta_key_name($meta_key, $meta_value);
		wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'false'));
	}
	if($user_display_name != 'null'){
		$users = get_user_info_by_display_name($user_display_name);
		create_new_conversation($user['ID']);
		wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'true'));
	}
	if($user_roles != 'null'){
		$user_roles_array = array_map('trim', explode(',', $user_roles));
		$users = get_user_info_by_role($user_roles_array);
		wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'false'));
	}
	if(is_user_logged_in()) {
		return '<div  id="yobro-inbox"></div>';
	}else{
		return '<a href="' .wp_login_url(). '">Please Login to Chat</a>';
	}
}

function yobro_chat_notification() {
	global $has_yobro_shortcode;
	$has_yobro_shortcode = true;
	$users = get_all_user_info();
	yobro_localize_scripts();
	wp_localize_script( 'app-frontend','USERS', array( 'all_users' => $users, 'isSingle' => 'false'));
	if(is_user_logged_in()) {
		return '<div className="unseenMsgWrapper" id="yobro-notification"></div>';
	}else{
		return '<a href="' .wp_login_url(). '">Please Login to Chat</a>';
	}
}

function yobro_chat_new_message($atts) {
	global $has_yobro_shortcode;
	$has_yobro_shortcode = true;
	 $atts = extract(shortcode_atts( array(
        'user_id' => '',
        'new_message' => 'false',
    ), $atts ));
		if($user_id != 'null'){
			create_new_conversation($user_id);
			yobro_localize_scripts();
			wp_localize_script( 'app-frontend','USERS', array( 'all_users' => get_single_user_info($user_id), 'isSingle' => 'true'));
		}
	if(is_user_logged_in() && get_current_user_id() != $user_id) {
		return '<div id="yobro-new-message" data-id="'.$user_id.'" data-new_message="'.$new_message.'"> </div>';
	}else if(get_current_user_id() != $user_id){
		return '<a href="' .wp_login_url(). '">Please Login to Chat</a>';
	}
}

function bulk_message($atts)
{
	extract(shortcode_atts(
		array(
			'data' => ''
		)
		, $atts));
		if(is_user_logged_in()) {
			yobro_localize_scripts();
			wp_localize_script( 'app-frontend','USERS', array( 'all_users' => get_all_user_info(), 'isSingle' => 'false'));
			return '<div id="yobro-bulk-message"> </div>';
		}else if(get_current_user_id() != $user_id){
			return '<a href="' .wp_login_url(). '">Please Login to Chat</a>';
		}
}

function userList()
{?>
	<div  id="yobro-bulk-one" class="yobro-bulk" data-id="2">26</div>
	<div  id="yobro-bulk-two" class="yobro-bulk" data-id="3">25</div>
	<div  id="yobro-bulk-three" class="yobro-bulk" data-id="8">23</div>
<?php }
