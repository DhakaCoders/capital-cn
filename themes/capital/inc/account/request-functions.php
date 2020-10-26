<?php
add_action('wp_enqueue_scripts', 'user_request_action_hooks');

function user_request_action_hooks(){
		ajax_user_request_init();
}


function ajax_user_request_init(){
    wp_register_script('ajax-user-request-script', get_stylesheet_directory_uri(). '/assets/js/ajax-call.js', array('jquery') );
    wp_enqueue_script('ajax-user-request-script');

    wp_localize_script( 'ajax-user-request-script', 'ajax_user_request_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
    // Enable the user with no privileges to run ajax_login() in AJAX
}
//add_action('wp_ajax_nopriv_user_request_data', 'user_request_data');
add_action('wp_ajax_user_request_data', 'user_request_data');
function user_request_data(){
	$data = array();
	if (isset( $_POST["request_type"] ) && wp_verify_nonce($_POST['user_request_nonce'], 'user-request-nonce')) {
		global $wpdb;
	    $user_id = get_current_user_id();
		$request_type = sanitize_text_field($_POST['request_type']);
		$fileID = sanitize_text_field($_POST['request_file']);
		$request_notes = sanitize_text_field($_POST['request_notes']);
		$receiver_id = get_user_meta( $user_id, 'accesspermission', true );
	    $receiver_data = get_user_by('id', $receiver_id);
	    $fileID = !empty($fileID)? $fileID:0;
		$table = $wpdb->prefix . 'request'; 
		$status = false;
		if( !empty($request_type) && !empty($request_notes) && !empty($receiver_id) && !empty($user_id) ){
			$status = Cbv_Db_Query::create($table, array(
				'sender_id' => $user_id,
				'request_type' => $request_type,
				'request_details' => $request_notes,
				'file_id' => $fileID,
				'receiver_id' => $receiver_id,
				'created_at' => date('Y-m-d H:i:s'),
			));
		}

		if($status){
			// mail script

			$data['success'] = 'The Request has been sent successfully!';
		}else{
			$data['error'] = 'The Request has not been sent!';
		}
		echo json_encode($data);
		wp_die();
	}
}
