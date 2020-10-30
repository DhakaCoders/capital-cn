<?php

namespace YoBro\App;
use YoBro\App\Up_Email;
use YoBro\App\YoBro_S3_Handler;
use YoBro\App\Attachment;


class YoBro_Ajax {

	public function __construct(){
		$ajax_events = array(
			'grab_conversation_message' => true,
			'push_new_message' => true,
			'message_seen' => true,
			'auto_pull_messages' => true,
			'grab_latest_conversation'=>true,
			'create_new_message' => true ,
			'delete_message' => true ,
			'delete_conversation' => true ,
			'block_user' => true ,
			'unblock_user' => true ,
			'asset_upload' => true,
			'create_bulk_message' => true,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_up_' . $ajax_event, array( $this, $ajax_event ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_up_' . $ajax_event, array( $this , $ajax_event ) );
			}
		}
	}

	public function grab_conversation_message(){
		if( isset( $_POST['convId']) ){
			$convId = $_POST['convId'];
			$messages = apply_filters('yobro_conversation_messages', get_few_messages_by_conversation($convId));
		}
		echo json_encode( array( 'success'=> true , 'messages'=> $messages ) );
		wp_die();
	}

	public function push_new_message(){
		if( isset( $_POST['conv_id']) && !empty($_POST['conv_id'] ) ){

			$store_message = apply_filters('yobro_before_store_new_message', do_store_message($_POST));
			do_action('yobro_after_store_message', $store_message);
			if( isset( $store_message['id']) ){
				$store_message['owner'] = 'true';
				if( get_user_meta( $store_message['sender_id'] , 'user_mini_photo' , true ) ){
					$store_message['pic'] =  get_user_meta( $store_message['sender_id'] , 'user_mini_photo' , true );
				}else{
					$store_message['pic'] =  get_avatar($store_message['sender_id']);
				}
				$store_message['time'] = $store_message['created_at'];
			}
			echo json_encode( array( 'pushed'=>true ,'message' => $store_message ) );
		}
		wp_die();
	}


	public function message_seen(){
		if( isset( $_POST['conv_id'] ) && !empty( $_POST['conv_id'] ) ){
			$conv_id = $_POST['conv_id'];
			$last_message_sender = $_POST['sender_id'];
			$has_seen_message = do_message_seen( $conv_id , $last_message_sender , $_POST['id'] );
			if($has_seen_message){
				do_action('yobro_message_has_seen', $conv_id, $last_message_sender, $_POST['id']);
			}
		}
		wp_die();
	}


	public function auto_pull_messages(){
		if( isset( $_POST['conv_id'] ) && !empty( $_POST['conv_id'] ) ){
			$messages = get_inbox_messages(array(
				'pull_conv_message' => $_POST['conv_id'],
				'last_message' => $_POST
			));
			$messages = apply_filters('yobro_automatic_pull_messages', $messages);
			if( !empty($messages) ){
				echo json_encode( array('autopush_messages'=> $messages) );
			}
		}
		wp_die();
	}

	public function grab_latest_conversation(){
		$users = ($_POST['all_users']) ? $_POST['all_users'] : [];
		$unseen_conversation = array();
		$conversations = get_users_all_conversation( get_current_user_id() );
		$processed_conversation = array();
		foreach ($conversations['conversation'] as $key => $single_conversation) {
			foreach ($users as $key => $single_user) {
				if($single_user['ID'] == $single_conversation['sender'] || $single_user['ID'] == $single_conversation['reciever']){
					$processed_conversation[] = $single_conversation;
				}
			}
		}
		$conversations['conversation'] = $processed_conversation;
		$conversations = apply_filters('yobro_latest_conversations', $conversations);
		echo json_encode(array('new_conversations' => $conversations ));
		wp_die();
	}

	public function create_new_message() {
		if( isset( $_POST['reciever_id'] ) && !empty( $_POST['reciever_id'] ) ){
			$reciever_id = $_POST['reciever_id'];
			$text = $_POST['text'];
		}
		$conversation = create_new_message_if_possible( $reciever_id , $text);
		$conversation = apply_filters('yobro_new_conversation', $conversation);
		do_action('yobro_new_conversation_created', $conversation);
		echo json_encode( $conversation );
		wp_die();
	}

	public function delete_message() {
		$message_id = $_POST['id'];
		$message_deleted = delete_message($message_id);
		if($message_deleted) {
			do_action('yobro_message_deleted', $message_id);
		}
	}

	public function delete_conversation() {
		$conversation_id = $_POST['id'];
		delete_conversation($conversation_id);
	}
	public function block_user() {
		$blocked_user = $_POST['blocked_user'];
		$blocked_user_array = block_user($blocked_user);
		do_action('yobro_block_user', $unblocked_user_id = $_POST['blocked_user'], get_current_user_id());
		echo json_encode( $blocked_user_array );
		wp_die();
	}
	public function asset_upload() {
		$new_message = json_decode( stripslashes_deep(html_entity_decode($_POST['details'])), true);
		$allFiles = $_FILES;
		if (isset($allFiles) && !empty($allFiles)) {
			$s3 = new YoBro_S3_Handler();
			$uploaded_files = [];
			foreach ($allFiles as $key => $singleFile) {
				$uploaded_files[$key]['url'] = $s3->uploadImageToS3($singleFile['tmp_name'], 'false');
				if(strpos($singleFile['type'], 'image') !== false){
					$uploaded_files[$key]['thumbnail_url'] = $s3->uploadImageToS3($singleFile['tmp_name'], 'true');
				}
				$uploaded_files[$key]['type'] = $singleFile['type'];
				$uploaded_files[$key]['size'] = $singleFile['size'];
			}
			try {
				$new_attachment = Attachment::create([
					'type_t' => null,
					'conv_id' => $new_message['conv_id'],
					'url' => json_encode($uploaded_files),
					'size' => null,
				]);
			} catch (Exception $e) {
				$error = [
					'status_code' => 400,
					'message' => $e->messages()
				];
	      echo json_encode( $error );
			}
			apply_filters('yobro_new_uploaded_assets', $new_attachment);
			if (isset($new_attachment)) {
				$new_message['attachment_id'] = $new_attachment['id'];
				$stored_message = do_store_message($new_message);
				$stored_message['attachments'] = $new_attachment;
				apply_filters('yobro_message_with_attachments', $stored_message);
				echo json_encode($stored_message);
			}
		}
		wp_die();
	}
	public function unblock_user() {
		$blocked_user = $_POST['blocked_user'];
		$blocked_user_array = unblock_user($blocked_user);
		do_action('yobro_unblock_user', $unblocked_user_id = $_POST['blocked_user'], get_current_user_id());
		echo json_encode( $blocked_user_array );
		wp_die();
	}

	public function create_bulk_message()
	{
		send_bulk_messages($_POST);
	}
}
