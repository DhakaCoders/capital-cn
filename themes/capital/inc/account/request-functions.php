<?php
add_action('wp_enqueue_scripts', 'user_request_action_hooks');
function user_request_action_hooks(){
		ajax_user_request_init();
		ajax_user_conversation_init();
		ajax_get_conversation_init();
}

function ajax_user_conversation_init(){
    wp_register_script('ajax-user-conversation-script', get_stylesheet_directory_uri(). '/assets/js/ajax-call.js', array('jquery') );
    wp_enqueue_script('ajax-user-conversation-script');

    wp_localize_script( 'ajax-user-conversation-script', 'ajax_user_conversation_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
    // Enable the user with no privileges to run ajax_login() in AJAX
}
//add_action('wp_ajax_nopriv_user_request_data', 'user_request_data');
add_action('wp_ajax_user_conversation_data', 'user_conversation_data');
function user_conversation_data(){
	$data = array();
	if (isset( $_POST["message"] ) && wp_verify_nonce($_POST['user_conversation_nonce'], 'user-conversation-nonce')) {
		global $wpdb;
	    $user_id = get_current_user_id();
		$receiver_id = sanitize_text_field($_POST['receiver_id']);
		$message = sanitize_text_field($_POST['message']);
		$table = $wpdb->prefix . 'conversation'; 
		$status = false;
		$unser = array();
		if( !empty($receiver_id) && !empty($message) ){
			$status = Cbv_Db_Query::create($table, array(
				'sender_id' => $user_id,
				'message' => $message,
				'receiver_id' => $receiver_id,
				'created_at' => date('Y-m-d H:i:s'),
			));
			
		}

		if($status){
			// mail script
			$data['message'] = '<div class="message-sender"><span class="sender">'.$message.'</span></div>';
			$data['success'] = 'success';
		}else{
			$data['error'] = 'error';
		}
		echo json_encode($data);
		wp_die();
	}
}

function ajax_get_conversation_init(){
    wp_register_script('ajax-get-conversation-script', get_stylesheet_directory_uri(). '/assets/js/ajax-call.js', array('jquery') );
    wp_enqueue_script('ajax-get-conversation-script');

    wp_localize_script( 'ajax-get-conversation-script', 'ajax_get_conversation_date_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ));
    // Enable the user with no privileges to run ajax_login() in AJAX
}
//add_action('wp_ajax_nopriv_user_request_data', 'user_request_data');
add_action('wp_ajax_get_conversation_date', 'get_conversation_date');
function get_conversation_date(){
	$data = array();
	if (isset( $_POST["none"] ) && $_POST["none"] == 'none') {
		global $wpdb;
		$receiverid = $_POST["receiverid"];
	    $senderid = get_current_user_id();
		$table = $wpdb->prefix . 'conversation';

		$totalcount = $wpdb->get_var ("
        SELECT COUNT(*)
        FROM  $table 
        WHERE (receiver_id =  $senderid AND sender_id =  $receiverid AND status = 'unread')
        ");
        if($totalcount){
        	$data['unreadcount'] = $totalcount;
        }else{
        	$data['unreadcount'] = 0;
        }


		$results = $wpdb->get_results ("
        SELECT * 
        FROM  $table 
        WHERE (sender_id =  $senderid AND receiver_id = $receiverid)
        OR (sender_id =  $receiverid AND receiver_id = $senderid)
        ");


		if($results){
			$output = '';
			foreach ($results as $key => $value) {
	            if($receiverid == $value->sender_id ){
	                $output .= "<div class='message-receiver'><span class='chatavatar'></span><span class='receiver'>$value->message</span></div>";
	            }else{
	               $output .= "<div class='message-sender'><span class='sender'>$value->message</div>"; 
	            }
			}
			$data['success'] = $output;
		}else{
			$data['error'] = 'error';
			
		}
		echo json_encode($data);
		wp_die();
	}
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
	    $receiver_email = get_user_by('email', $receiver_id);
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
		    $body = '<p><strong>Request Type:</strong> '.$request_type.'</p>';
		    $body .= '<p><strong>Request Type:</strong></p>';
		    $body .= '<p>'.$request_notes.'</p>';
		    $send = wp_mail( $receiver_email, 'Client Request', $body );
		    if($body){
				$data['success'] = 'The Request has been sent successfully!';
			}else{
				$data['error'] = 'The Request has not been sent!';
			}
		}else{
			$data['error'] = 'The Request has not been sent!';
		}
		echo json_encode($data);
		wp_die();
	}
}
