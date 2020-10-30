<?php 
function wpCheckloggetout(){
	if( !is_user_logged_in() ){
		wp_redirect( home_url());
		exit();
	}
}

function wpCheckLoggedin(){
	if( is_user_logged_in() ){
		wp_redirect( home_url('account') );
		exit();
	}
}

function redirect_page_notfound(){
	$siteurl = home_url('404');
	echo '<script> location.replace("'.$siteurl.'"); </script>';
	exit();
}

function get_custom_logout($page_link = ''){
    if(!empty($page_link)){
      echo wp_logout_url( site_url() . '/'.$page_link );
    }else{
      echo wp_logout_url( site_url());
    }
    
}

function current_user_data(){
	if( is_user_logged_in() ){
		$datas = wp_get_current_user();
		return $datas;
	}else{
		return false;
	}
	
}


add_action('wp_enqueue_scripts', 'action_init_hooks');

function action_init_hooks(){
	if( !is_user_logged_in() ){
		user_login_account();
		user_forget_password();
		user_set_password();
	}
}
function user_login_account(){
	global $login_errors;
	$login_errors = array();
	if (isset( $_POST["email"] ) && wp_verify_nonce($_POST['user_login_nonce'], 'user-login-nonce')) {
		$success = true;
		if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
			$user = get_user_by( 'email', sanitize_email($_POST["email"]) );
			$data['email'] = ' ';
		}elseif(empty($_POST["email"])){
			$login_errors['email'] = 'Email is required';
			$success = false;
			$user = false;
		}
		$password = esc_attr($_POST['password']);
		$data['pass'] = ' ';
		if(empty($password)) {
			$login_errors['pass'] = 'Password is required';
			$success = false;
			$user = false;
		}

		
		// this returns the user ID and other info from the user name
		if( isset($user) && $user ){

	 		if(!$user || !wp_check_password($password, $user->user_pass, $user->ID)) {
				// if the user name doesn't exist
				$login_errors['loging_error'] = 'Unsuccessfully Your Login';
				$success = false;
			}

			if($success){
		        wp_clear_auth_cookie();
	            wp_set_current_user( $user->ID, $user->user_login );
	            if (wp_validate_auth_cookie()==FALSE)
				{
				    wp_set_auth_cookie($user->ID, false, false);
				}
	            do_action( 'wp_login', $user->user_login );
	            if ( is_user_logged_in() ){
	            	wp_redirect( home_url());
	            	exit();
	            }
	        }
		}else{
			$login_errors['loging_error'] = 'Unsuccessfully Your Login';
		}

	}
	return false;
}
function user_forget_password(){
	global $email_errors;
	$email_errors = array();
	if (isset( $_POST["exists_email"] ) && wp_verify_nonce($_POST['forget_password_nonce'], 'forget-password-nonce')) {
		$success = true;
		if (filter_var($_POST["exists_email"], FILTER_VALIDATE_EMAIL)) {
			$user = get_user_by( 'email', sanitize_email($_POST["exists_email"]) );
		}
		
		// this returns the user ID and other info from the user name
		if( isset($user) && $user ){
			$unique_code = substr(number_format(time() * rand(),0,'',''),0,6);
			update_user_meta( $user->ID, 'new_password_code', $unique_code );
			$redirect_to = site_url('set-password/?token='.$unique_code);
	    	$body  = '<p>Hi!</p>';
		    $body .= '<p>If you would like to set a new password, please <a href="'.$redirect_to.'">click on this link</a></p>';
		    $send = wp_mail( $_POST["exists_email"], 'New Password', $body );
		    if($body){
				$email_errors['email_success'] = 'Please check your email and click on the link to set a new password';
			}else{
				$email_errors['email_error'] = 'Something went wrong! Please try again.';
			}
		}else{
			$email_errors['email_error'] = 'Email address does not found';
		}

	}
	return false;
}

function user_set_password(){
	global $email_errors;
	$email_errors = array();
	if (isset( $_POST["new_password"] ) && isset( $_POST["token"] ) && wp_verify_nonce($_POST['set_password_nonce'], 'set-password-nonce')) {
		if ( !empty($_POST["token"] ) ) {
			$token = $_POST["token"];
			$users = get_users(array('meta_key' => 'new_password_code', 'meta_value' => $token));
			// this returns the user ID and other info from the user name
			if( isset($users) && $users ){
				foreach ($users as $key => $user) {
					$userID = $user->ID;
				}
				$new_pass = $_POST["new_password"];
				$redirect_to = site_url();
		    	$userdata = array(
			            'ID'        =>  $userID,
			            'user_pass' =>  $new_pass,
		        );  
	    		$user_id = wp_update_user($userdata);
	    		if($user_id){
	    			update_user_meta( $user_id, 'new_password_code', '' );
	    			$email_errors['email_success'] = 'Password has been updated successfully.';
	    		}else{
	    			$email_errors['email_error'] = 'Password has not been updated successfully.';
	    		}
			}else{
				$email_errors['email_error'] = 'Perhaps your token is being expired. Please go back your email and click the link again.';
			}
		}else{
			$email_errors['email_error'] = 'Token is required.';
		}

	}
	return false;
}

add_action('admin_head', 'redirect_user_frontend_dashboard');
function redirect_user_frontend_dashboard(){
  $user = wp_get_current_user();
  if( is_admin() ){
    if ( in_array( 'client', (array) $user->roles ) && is_user_logged_in() ) {
      $redirect_to = site_url();
      echo '<script>window.location.href="'.$redirect_to.'"</script>';
      exit();
    }
  }
   return false;
}



function get_current_user_name(){
   $user = wp_get_current_user();
   if ( $user &&  is_user_logged_in() ) {
      if(!empty($user->display_name)){
        echo $user->display_name;
      }else{
        echo $user->user_nicename;
      }
   }
   return false;
}


function get_user_image(){
	$user = wp_get_current_user();
	if( $user ):
	$imageID = get_user_meta($user->ID, 'profileimage', true);
	if( isset($imageID) && !empty($imageID)){
	  $imgtag = cbv_get_image_tag( $imageID);
	  echo $imgtag;
	}else{
	  echo '<img src="'.THEME_URI.'/assets/images/profile-dflt.jpg" alt="Profile Image">';
	}
	endif;
}

function get_user_image_url($id){
	if( empty($id) ) return;
	$imageID = get_user_meta($id, 'profileimage', true);
	if( isset($imageID) && !empty($imageID)){
	  $imgtag = cbv_get_image_src( $imageID);
	  return $imgtag;
	}else{
	  return THEME_URI.'/assets/images/profile-dflt.jpg';
	}
}

function get_user_image_tag($id){
	if( empty($id) ) return;
	$imageID = get_user_meta($id, 'profileimage', true);
	if( isset($imageID) && !empty($imageID)){
	  $imgtag = cbv_get_image_tag( $imageID);
	  return $imgtag;
	}else{
	  return '<img src="'.THEME_URI.'/assets/images/profile-dflt.jpg" alt="Profile Image">';
	}
}