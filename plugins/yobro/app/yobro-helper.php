<?php


function get_inbox_messages( $data ) {

  if( isset( $data['pull_conv_message'] ) && !empty( $data['pull_conv_message'] ) ){

    $conv_id = $data['pull_conv_message'];
    $last_message = $data['last_message'];
    $autopush_message = get_conversation_autopush_message( $conv_id , $last_message);

    if( !empty($autopush_message) ){

      foreach ($autopush_message as &$message) {
				$message['message'] = encrypt_decrypt($message['message'], $message['sender_id'], 'decrypt');
        if( $message['sender_id'] == get_current_user_id() ) {
          $message['owner'] = 'true';
        }else{
  				$message['owner'] = 'false';
  			}

        if( get_avatar( $message['sender_id']) ){
          $message['pic'] =  get_avatar( $message['sender_id']);
        }else{
          $message['pic'] =  get_avatar( $message['sender_id']);
        }

				if(isset($message['attachment_id']) && $message['attachment_id'] != null){
	        $message['attachments'] = YoBro\App\Attachment::where('id', '=', $message['attachment_id'])->first();
	      }
        $message['reciever_name'] = get_user_name_by_id($message['reciever_id']) ?  get_user_name_by_id($message['reciever_id']) : 'Untitled' ;
        $message['sender_name'] = get_user_name_by_id($message['sender_id']) ?  get_user_name_by_id($message['sender_id']) : 'Untitled' ;
        $message['time'] = $message['created_at'];
      }
    }
  }

  $last_five_deleted_messages = \YoBro\App\Message::where('conv_id', '=', $conv_id)->where('delete_status', '=', 1)->take(5)->get()->toArray();
  return [
    'new_unseen_messages' => $autopush_message,
    'last_five_deleted_messages' => $last_five_deleted_messages
  ];
}


function get_conversation_autopush_message( $conv_id , $last_message ){
  // need to get unseen messages , by the reciever .

  if( $last_message['sender_id'] == get_current_user_id() ){
    $reciever_id = $last_message['reciever_id'];
  }else{
    $reciever_id = $last_message['sender_id'];
  }

  $unseen_messages =  \YoBro\App\Message::where('sender_id','=',$reciever_id)->where('seen','=',null)->where('conv_id','=',$conv_id)->where('delete_status', '!=', 1)->orderBy('created_at','desc')->get()->toArray();

  return $unseen_messages;
}

/*
get conversation and do some processing
*/
function get_users_all_conversation( $user_id , $limit = 10 ){
  $all_conversations =  \YoBro\App\Conversation::where('sender', '=', $user_id)
          ->orWhere('reciever','=', $user_id)->orderBy('created_at','desc')->get()->toArray();
  if( !empty($all_conversations) ){
    foreach ($all_conversations as &$conversation) {
      $conversation['sender_name'] = get_user_name_by_id($conversation['sender']);
      $conversation['reciever_name'] = get_user_name_by_id($conversation['reciever']);
      if( $user_id == $conversation['sender'] ){
          $conversation['name'] = $conversation['reciever_name'];
        if(  get_avatar( $conversation['reciever']) ){
          $conversation['pic'] =  get_avatar( $conversation['reciever']);
        }else{
          $conversation['pic'] =  up_user_placeholder_image();
        }
      }else{
          $conversation['name'] =  $conversation['sender_name'];
        if( get_avatar( $conversation['sender']) ){
          $conversation['pic'] = get_avatar( $conversation['sender']);
        }else{
          $conversation['pic'] =  up_user_placeholder_image();
        }
      }

      // need to get last message and its time .
      $last_message = \YoBro\App\Message::where('conv_id', '=', $conversation['id'])->where('delete_status', '!=', 1)->orderBy('id','desc')->take(1)->get()->toArray();
      if( !empty($last_message) ){
        $conversation['message'] = encrypt_decrypt($last_message[0]['message'], $last_message[0]['sender_id'], 'decrypt');
        $conversation['message_id'] = $last_message[0]['id'];
        $conversation['time'] = $last_message[0]['created_at'];
        $conversation['last_sender'] = $last_message[0]['sender_id'];
        $conversation['message_exists'] = 'true';
				if( $last_message[0]['sender_id'] != get_current_user_id() ){
          $conversation['seen'] = $last_message[0]['seen'] != 1 ? false: true;
        }else{
          $conversation['seen'] = true;
        }
				if(isset($last_message['attachment_id']) && $last_message['attachment_id'] != null){
	        $conversation['attachments'] = YoBro\App\Attachment::where('id', '=', $last_message['attachment_id'])->first();
	      }
			}
			else{
        $conversation['time'] = $conversation['created_at'];
				$conversation['message_exists'] = 'false';
				$conversation['message'] = '';
      }
    }
    $time = array();
    foreach ($all_conversations as $key => $val) {
      $time[$key] = $val['time'];
    }
    array_multisort($time, SORT_DESC , $all_conversations);
		// return $all_conversations;
  }else{
    $all_conversations =  array();
  }
  // $deleted_conversation = \YoBro\App\DeleteConversation::where('user', '=', $user_id)->get()->toArray();
  $blocked_user =  \YoBro\App\BlockConversation::where('blocked_by', '=', $user_id)->get()->toArray();
  $blocked_by =  \YoBro\App\BlockConversation::where('blocked_user', '=', $user_id)->get()->toArray();
  return array(
    'conversation' => $all_conversations,
    'blocked_user' => $blocked_user,
    'blocked_by' => $blocked_by,
  );
}



function get_few_messages_by_conversation($conv_id){
  $current_user_id = get_current_user_id();
  $messages = \YoBro\App\Message::where('conv_id','=',$conv_id )
                                ->where('delete_status', '!=', 1)
                                ->where(function($query) use ($current_user_id) {
                                  $query->where('sender_id', $current_user_id)
                                        ->orWhere('reciever_id', $current_user_id);
                                })
                                ->orderBy('id','asc')->get()->toArray();
  $total_messages = array();
  if( isset($messages) && !empty($messages) ){
    foreach ($messages as &$message) {
      $message['message'] = encrypt_decrypt($message['message'], $message['sender_id'], 'decrypt');
      if( $message['sender_id'] == get_current_user_id() ) {
        $message['owner'] = 'true';
      }else{
				$message['owner'] = 'false';
			}
      // if( bp_core_fetch_avatar( array( 'item_id' => $message['sender_id'], 'type' => 'thumb')) ){
      //   $message['pic'] =  bp_core_fetch_avatar( array( 'item_id' => $message['sender_id'], 'type' => 'thumb', 'html'   => FALSE ));
      // }else{
      //   $message['pic'] =  up_user_placeholder_image();
      // }
      if( get_avatar($message['sender_id']) ){
        $message['pic'] =  get_avatar($message['sender_id']);
      }else{
        $message['pic'] =  up_user_placeholder_image();
      }
      $message['reciever_name'] = get_user_name_by_id($message['reciever_id']) ?  get_user_name_by_id($message['reciever_id']) : 'Untitled' ;
      $message['sender_name'] = get_user_name_by_id($message['sender_id']) ?  get_user_name_by_id($message['sender_id']) : 'Untitled' ;
      $message['time'] = $message['created_at'];
      if(isset($message['attachment_id']) && $message['attachment_id'] != null){
        $message['attachments'] = YoBro\App\Attachment::where('id', '=', $message['attachment_id'])->first();
      }
      if( !isset($total_messages[ $message['id'] ]) ){
        $total_messages[ $message['id'] ] = $message;
      }
    }
    return $total_messages;
  }else{
    return array();
  }
}

function do_store_message( $message ){
  $attachment_id = isset($message['attachment_id']) ? $message['attachment_id'] : null;
  $new_message  = \YoBro\App\Message::create(array(
    'conv_id' => $message['conv_id'],
    'attachment_id' => $attachment_id,
    'sender_id' => $message['sender_id'],
    'reciever_id' => $message['reciever_id'],
    'message' => encrypt_decrypt($message['message'], $message['sender_id']),
    'created_at' => date("Y-m-d H:i:s")
  ));
  if (isset($message['attachment_id'])) {
    $update_attachment =  \YoBro\App\Attachment::where('id', '=', $message['attachment_id'])->update(array('conv_id' => $message['conv_id']));
  }
  if( $new_message ){
    $new_message['message'] = encrypt_decrypt($new_message['message'], $new_message['sender_id'], 'decrypt');
    return $new_message;
  }

}

function encrypt_decrypt($string, $user_id, $action = 'encrypt') {
  // $user_id = get_current_user_id();
  $secret_key = $user_id;
  $secret_iv = $user_id;

  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash( 'sha256', $secret_key );
  $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

  if( $action == 'encrypt' ) {
      $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
  }
  else if( $action == 'decrypt' ){
      $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
  }
  return $output;
}


function do_message_seen( $conv_id , $last_message_sender , $id ){

  \YoBro\App\Message::where('sender_id','=',$last_message_sender)->where('seen','=',null)->where('conv_id','=',$conv_id)->where('id','<=',$id )->update(array('seen'=> 1));

  return true;
}


function get_user_pic( $user_id ){

  if( get_user_meta( $user_id , 'user_mini_photo' , true ) ){
    return get_user_meta( $user_id , 'user_mini_photo' , true );
  }else{
    return 'up_user_placeholder_image()';
  }

}




function get_all_user_info(){

	$all_users = get_users();
  $publish = array();
  foreach( $all_users as $user ) {
    if( get_current_user_id() != $user->ID ){

      $publish[] = array(
        'ID' => $user->ID ,
        'name' => get_user_name_by_id($user->ID),
        'pic' => get_avatar($user->ID ),
        'username' => $user->data->user_login
      );

    }

  }

  if( !empty($publish) ){
    return $publish;
  }else{
    return array();
  }
}
function get_user_info_by_role($roles){

  $all_users = get_users(array(
		'role__in'     => $roles,
	));
  $publish = array();
  foreach( $all_users as $user ) {
    if( get_current_user_id() != $user->ID ){
      $publish[] = array(
        'ID' => $user->ID ,
        'name' => get_user_name_by_id($user->ID),
        'pic' => get_avatar($user->ID ),
        'username' => $user->data->user_login
      );
    }
  }

  if( !empty($publish) ){
    return $publish;
  }else{
    return array();
  }
}

function get_single_user_info($user_id){
  $user = get_user_by('id', $user_id);
  $user_info = array();
  if( $user && (get_current_user_id() != $user->ID) ){
    $user_info[] = array(
      'ID' => $user->ID ,
      'name' => get_user_name_by_id($user->ID),
      'pic' => get_avatar($user->ID ),
      'username' => $user->data->user_login
    );
  }

  return $user_info;
}
function get_user_info_by_display_name($display_name){
	global $wpdb;
  $query = $wpdb->prepare("SELECT users.ID, users.user_login as username FROM {$wpdb->users} as users
    WHERE users.display_name = %s", $display_name);
  $results = $wpdb->get_results($query, 'ARRAY_A');
	foreach ($results as $key => $user) {
		$results[$key]['name'] = get_user_name_by_id($user['ID']);
		$results[$key]['pic'] = get_avatar($user['ID']);
	}
  return $results;
}

function get_user_info_by_meta_key_name($meta_key, $meta_value){
  global $wpdb;
  $query = $wpdb->prepare("SELECT users.ID, users.user_login as username FROM {$wpdb->users} as users
    LEFT JOIN {$wpdb->usermeta} as meta ON users.ID = meta.user_id
    WHERE meta.meta_key = %s AND meta.meta_value = %s", $meta_key, $meta_value);
  $results = $wpdb->get_results($query, 'ARRAY_A');
	foreach ($results as $key => $user) {
		$results[$key]['name'] = get_user_name_by_id($user['ID']);
		$results[$key]['pic'] = get_avatar($user['ID']);
	}
  return $results;
}

function create_new_conversation($reciever_id){
  $new_conversation =  \YoBro\App\Conversation::where(function ($query) use ($reciever_id) {
    $query->where('sender', '=', get_current_user_id())
          ->where('reciever','=', $reciever_id);
    })->orWhere(function ($query) use ($reciever_id) {
        $query->where('sender','=',$reciever_id)
              ->where('reciever','=', get_current_user_id());
    })->orderBy('created_at','desc')->first();
  if( empty($new_conversation) ){
    $new_conversation =  \YoBro\App\Conversation::create(array(
      'sender' => get_current_user_id(),
      'reciever'=> $reciever_id,
    ));
  }
}



function create_new_message_if_possible( $reciever_id , $text){

  $new_conversation =  \YoBro\App\Conversation::where(function ($query) use ($reciever_id) {
    $query->where('sender', '=', get_current_user_id())
          ->where('reciever','=', $reciever_id);
    })->orWhere(function ($query) use ($reciever_id) {
        $query->where('sender','=',$reciever_id)
              ->where('reciever','=', get_current_user_id());
    })->orderBy('created_at','desc')->first();

  if( !empty($new_conversation) ){
    // store message into that conv .

    // $conversation = $conversation->toArray();

    $new_message  = \YoBro\App\Message::create(array(
      'conv_id' => $new_conversation->id,
      'sender_id' => get_current_user_id(),
      'reciever_id' => $reciever_id ,
      'attachment_id' => null ,
			'message' => encrypt_decrypt($text, get_current_user_id()),
			'created_at' => date("Y-m-d H:i:s")
    ));

  }else{
    // create new conv & message
    $new_conversation =  \YoBro\App\Conversation::create(array(
      'sender' => get_current_user_id(),
			'reciever'=> $reciever_id,
			'created_at' => date("Y-m-d H:i:s")
    ));

    $new_message  = \YoBro\App\Message::create(array(
      'conv_id' => $new_conversation['id'],
      'sender_id' => get_current_user_id(),
      'reciever_id' => $reciever_id ,
      'message' => encrypt_decrypt($text, get_current_user_id()),
      'attachment_id' => null ,
			'created_at' => date("Y-m-d H:i:s")
    ));

  }
  if( $new_message && $new_conversation){

          $conversation['id'] = $new_conversation['id'];
          $conversation['sender'] = $new_message['sender_id'];
          $conversation['reciever'] = $new_message['reciever_id'];
          $conversation['sender_name'] = get_user_name_by_id($new_conversation['sender']);
          $conversation['reciever_name'] = get_user_name_by_id($new_conversation['reciever']);

          $user_id = get_current_user_id();
          if( $user_id == $new_conversation['sender'] ){

            if( $conversation['reciever_name'] ){
              $conversation['name'] = $conversation['reciever_name'];
            }else{
              $conversation['name'] = 'Untitled';
            }
            if( $new_conversation['sender'] == $user_id ) {
              $conversation['owner'] = 'true';
            }else{
      				$conversation['owner'] = 'false';
      			}
            if(  get_user_meta( $new_conversation['reciever'] , 'user_mini_photo' , true ) ){
              $conversation['pic'] =  get_user_meta( $new_conversation['reciever'] , 'user_mini_photo' , true );
            }else{
              $conversation['pic'] =  up_user_placeholder_image();
            }

          }else{

            if( $conversation['sender_name'] ){
              $conversation['name'] =  $new_conversation['sender_name'];
            }else{
              $conversation['name'] = 'Untitled';
            }

            if( get_user_meta( $new_conversation['sender'] , 'user_mini_photo' , true ) ){
              $conversation['pic'] = get_user_meta( $new_conversation['sender'] , 'user_mini_photo' , true );
            }else{
              $conversation['pic'] =  up_user_placeholder_image();
            }

          }

          // need to get last message and its time .
          // $last_message = \YoBro\App\Message::where('conv_id','=',$conversation['id'] )->orderBy('id','desc')->first()->toArray();

          if( !empty($new_message) ){

            $conversation['message'] = encrypt_decrypt($new_message['message'], $new_message['sender_id'], 'decrypt');
            $conversation['message_id'] = $new_message['id'];
            $conversation['time'] = $new_message['created_at'];
            $conversation['last_sender'] = $new_message['sender_id'];

            if( $new_message['sender_id'] != get_current_user_id() ){
              $conversation['seen'] = $new_message['seen'] ? true: false;
            }
          }

  }
	$older_messages = get_few_messages_by_conversation($new_conversation['id']);
  return [
    'conversation' => $conversation,
    'messages' => $older_messages
  ];

}
function send_bulk_messages($data){
  $text = $data['text'];
	foreach ($data['receiverList'] as $key => $reciever_id) {
  $new_conversation =  \YoBro\App\Conversation::where(function ($query) use ($reciever_id) {
    $query->where('sender', '=', get_current_user_id())
          ->where('reciever','=', $reciever_id);
    })->orWhere(function ($query) use ($reciever_id) {
        $query->where('sender','=',$reciever_id)
              ->where('reciever','=', get_current_user_id());
    })->orderBy('created_at','desc')->first();

  if( !empty($new_conversation) ){
    // store message into that conv .

    // $conversation = $conversation->toArray();

    $new_message  = \YoBro\App\Message::create(array(
      'conv_id' => $new_conversation->id,
      'sender_id' => get_current_user_id(),
      'reciever_id' => $reciever_id ,
      'attachment_id' => null ,
      'message' => encrypt_decrypt($text, get_current_user_id())
    ));

  }else{
    // create new conv & message
    $new_conversation =  \YoBro\App\Conversation::create(array(
      'sender' => get_current_user_id(),
      'reciever'=> $reciever_id,
    ));

    $new_message  = \YoBro\App\Message::create(array(
      'conv_id' => $new_conversation['id'],
      'sender_id' => get_current_user_id(),
      'reciever_id' => $reciever_id ,
      'message' => encrypt_decrypt($text, get_current_user_id()),
      'attachment_id' => null ,
			'created_at' => date("Y-m-d H:i:s")
    ));

  }
  // if( $new_message && $new_conversation){
  //
  //         $conversation['id'] = $new_conversation['id'];
  //         $conversation['sender_name'] = get_user_name_by_id($new_conversation['sender']);
  //         $conversation['reciever_name'] = get_user_name_by_id($new_conversation['reciever']);
  //
  //         $user_id = get_current_user_id();
  //         if( $user_id == $new_conversation['sender'] ){
  //
  //           if( $conversation['reciever_name'] ){
  //             $conversation['name'] = $conversation['reciever_name'];
  //           }else{
  //             $conversation['name'] = 'Untitled';
  //           }
  //           if( $new_conversation['sender'] == $user_id ) {
  //             $conversation['owner'] = 'true';
  //           }else{
  //     				$conversation['owner'] = 'false';
  //     			}
  //           if(  get_user_meta( $new_conversation['reciever'] , 'user_mini_photo' , true ) ){
  //             $conversation['pic'] =  get_user_meta( $new_conversation['reciever'] , 'user_mini_photo' , true );
  //           }else{
  //             $conversation['pic'] =  up_user_placeholder_image();
  //           }
  //
  //         }else{
  //
  //           if( $conversation['sender_name'] ){
  //             $conversation['name'] =  $new_conversation['sender_name'];
  //           }else{
  //             $conversation['name'] = 'Untitled';
  //           }
  //
  //           if( get_user_meta( $new_conversation['sender'] , 'user_mini_photo' , true ) ){
  //             $conversation['pic'] = get_user_meta( $new_conversation['sender'] , 'user_mini_photo' , true );
  //           }else{
  //             $conversation['pic'] =  up_user_placeholder_image();
  //           }
  //
  //         }
  //
  //         // need to get last message and its time .
  //         // $last_message = \YoBro\App\Message::where('conv_id','=',$conversation['id'] )->orderBy('id','desc')->first()->toArray();
  //
  //         if( !empty($new_message) ){
  //
  //           $conversation['message'] = encrypt_decrypt($new_message['message'], $new_message['sender_id'], 'decrypt');
  //           $conversation['message_id'] = $new_message['id'];
  //           $conversation['time'] = $new_message['created_at'];
  //           $conversation['last_sender'] = $new_message['sender_id'];
  //
  //           if( $new_message['sender_id'] != get_current_user_id() ){
  //             $conversation['seen'] = $new_message['seen'] ? true: false;
  //           }
  //         }
  //
  // }
	// $older_messages = get_few_messages_by_conversation($new_conversation['id']);
  // return [
  //   'conversation' => $conversation,
  //   'messages' => $older_messages
  // ];
	}
}


/**
* 	https://tommcfarlin.com/get-user-by-meta-data/
*/

function get_users_by_meta_data( $meta_key, $meta_value ) {

	// Query for users based on the meta data
	$user_query = new WP_User_Query(
		array(
			'meta_key'   =>	$meta_key,
			'meta_value' =>	$meta_value
		)
	);

	// Get the results from the query, returning the first user
	$users = $user_query->get_results();

	return $users;
}


/**
 *
 * @param int
 * @desc provide user profile info
 */

function get_users_profile_data( $user_id ){

	$user_data = array();

	$user                    =  wp_get_current_user();
	$user_data['id']		 = $user->ID;
	$user_data['user_email'] = $user->user_email;
	$user_data['first_name'] = $user->first_name;
	$user_data['last_name']  = $user->last_name;
	$user_data['placeholder']  = up_user_placeholder_image();


	$user_all = get_user_meta($user_id);

	if( !empty($user_all) ){

		// GRAB FROM META
		foreach( $user_all as $meta_key => $meta_value) {
			if( preg_match("/^user/", $meta_key) ){
				$user_data[$meta_key] = $meta_value[0];
			}
		}
	}


	return $user_data;
}



function get_user_name_by_id( $user_id ){
    $user = get_user_by( 'id', $user_id );
    $fullname = '';
    if( isset($user) && !empty($user)){
        $fullname = $user->first_name.' '.$user->last_name;
				if($fullname == ' '){
					$fullname = $user->user_login;
				}
    }

    return $fullname;
}


function up_user_placeholder_image() {
	return '<img alt="" src="'.YOBRO_IMG . 'user-placeholder.png" class="avatar avatar-96 photo" height="96" width="96" />';
}

function delete_message($id){
	\YoBro\App\Message::where('id','=',$id)->update(array('delete_status'=> 1));
  return true;
}

// function delete_conversation($id){
//   $user_id = get_current_user();
// 	\YoBro\App\Conversation::where('id','=',$id)->update(array('delete_status'=> 1, 'deleted_by' => $user_id));
// }
function block_user($blocked_user){
  $blocked_by = get_current_user_id();
	\YoBro\App\BlockConversation::create(array(
    'blocked_by' => $blocked_by,
    'blocked_user'=> $blocked_user,
  ));
	$blocked_user =  \YoBro\App\BlockConversation::where('blocked_by', '=', $blocked_by)->get()->toArray();
  $blocked_by =  \YoBro\App\BlockConversation::where('blocked_user', '=', $blocked_by)->get()->toArray();
  return [
    'blocked_by' => $blocked_by,
    'blocked_user'=> $blocked_user,
  ];
}
function unblock_user($blocked_user){
  $blocked_by = get_current_user_id();
	$blocked = \YoBro\App\BlockConversation::where('blocked_by','=',$blocked_by)->where('blocked_user', $blocked_user)->first();
  $blocked->delete();
  $blocked_user =  \YoBro\App\BlockConversation::where('blocked_by', '=', $blocked_by)->get()->toArray();
  $blocked_by =  \YoBro\App\BlockConversation::where('blocked_user', '=', $blocked_by)->get()->toArray();
  return [
    'blocked_by' => $blocked_by,
    'blocked_user'=> $blocked_user,
  ];
}

function get_yobro_avatar($id)
{
  $avater = get_avatar_data($id);
  if(isset($avater['url'])) return  $avater['url'];
}


// function up_authored_content( $query ) {
//
//   $current_user = wp_get_current_user();
//   $is_user = $current_user->user_login;
//     if (!current_user_can('manage_options')){
//         if($query->is_admin) {
//             global $user_ID;
//             $query->set('author',  $user_ID);
//         }
//         return $query;
//     }
//   return $query;
//
// }
// add_filter('pre_get_posts', 'up_authored_content');

function yobro_localize_scripts(){
  $yobro_scripts = json_decode(file_get_contents( YOBRO_DIR . "/resource/frontend-assets.json"),true);
  wp_register_script( 'app-frontend-vendor', YOBRO_JS_COMPILED. $yobro_scripts['vendor']['js'] , array('jquery', 'underscore'), $ver = false, true);
  wp_enqueue_script( 'app-frontend-vendor' );
  wp_register_script( 'app-frontend', YOBRO_JS_COMPILED. $yobro_scripts['yobro_frontend']['js'], array('jquery', 'underscore'), $ver = false, true );
  wp_enqueue_script( 'app-frontend');
  $all_images =	get_posts(array(
    'author'         => get_current_user_id(),
    'post_status'    => 'any',
    'post_type'      => 'attachment',
    'posts_per_page' => -1
  ));
  $all_user_images = array();

  foreach ($all_images as $img )  {
    $all_user_images[] = array(
      'id' => $img->ID,
      'url' => $img->guid
    );
  }

  wp_localize_script( 'app-frontend', 'API', array(
    'nonce' => wp_create_nonce( 'yobro' ),
    'ajaxurl' => admin_url('admin-ajax.php'),
    'all_images' => $all_user_images,
  ));

  wp_localize_script( 'app-frontend','PROFILE', array(
    'data' => get_users_profile_data( get_current_user_id() )
  ));
  $yobro_settings = get_option('yo_bro_settings', true);
  $assets = isset($yobro_settings['files_enable']) ? $yobro_settings['files_enable'] : 'disable';
  $max_file_size = isset($yobro_settings['max_file_size']) ? $yobro_settings['max_file_size'] : '5000';
  $Max_num_of_files = isset($yobro_settings['max_number_of_files']) ? $yobro_settings['max_number_of_files'] : '10';
  $multiple_files = isset($yobro_settings['multiple_files_enable']) ? $yobro_settings['multiple_files_enable'] : 'enable';
  $enable_avatar = isset($yobro_settings['yobro_enable_avatar']) ? $yobro_settings['yobro_enable_avatar'] : 'disable';
  $chat_page_url = isset($yobro_settings['chat_page_url']) ? $yobro_settings['chat_page_url'] : '';
  $chat_notification_number = isset($yobro_settings['chat_notification_number']) ? $yobro_settings['chat_notification_number'] : '5';
  $chat_button_name = isset($yobro_settings['chat_button_name']) ? $yobro_settings['chat_button_name'] : 'Chat';
  $number_of_messages = isset($yobro_settings['number_of_messages']) ? $yobro_settings['number_of_messages'] : 30;
	$lang = new YoBro\App\Localize();
	wp_localize_script( 'app-frontend','INBOX', array(
    '_WEBPACK_PUBLIC_PATH_' => YOBRO_JS_COMPILED,
    'LANG' => $lang->strings(),
    'conversations' => get_users_all_conversation( get_current_user_id() ),
    'owner_id' => get_current_user_id(),
    // 'all_users' => get_all_user_info(),
    'assets' => array(
      'enable_assets' => $assets,
      'max_file_size' => $max_file_size,
      'max_num_of_files' => $Max_num_of_files,
      'multiple_files' => $multiple_files,
    ),
    'redirect_chat_url' => $chat_page_url,
    'chat_notification_number' => $chat_notification_number,
    'chat_button_name' => $chat_button_name,
    'number_of_messages' => $number_of_messages,
    'enable_avatar' => $enable_avatar
  ));
}
