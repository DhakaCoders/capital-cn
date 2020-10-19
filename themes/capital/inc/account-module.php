<?php
include_once(THEME_DIR .'/account/login-functions.php');
include_once(THEME_DIR .'/account/admin-functions.php');

add_action('admin_init', 'add_custom_role');

function add_custom_role(){
  if(!get_role( 'client' )){
  	add_role('client', __(
     'Client')
  	);
  }
  if(!get_role( 'rsmanager' )){
  	add_role('rsmanager', __(
  		'RS Manager')
  	);
  }

}


//add_action('init', 'allow_ngo_uploads');
if(!function_exists('allow_ngo_uploads')){
  function allow_ngo_uploads() {

    $b_role = get_role('business');
    $b_role->add_cap('read');
    $b_role->add_cap('upload_files');
    $b_role->add_cap('delete_posts');
    $b_role->add_cap('edit_posts');


    $sb_role = get_role('subscriber');
    $sb_role->add_cap('upload_files');
  }
}