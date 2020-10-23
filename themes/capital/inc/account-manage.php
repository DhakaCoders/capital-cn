<?php
include_once(THEME_DIR .'/inc/account/query.php');
include_once(THEME_DIR .'/inc/account/login-functions.php');
include_once(THEME_DIR .'/inc/account/admin-functions.php');
include_once(THEME_DIR .'/inc/account/request-functions.php');

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


add_action('init', 'allow_ngo_uploads');
if(!function_exists('allow_ngo_uploads')){
  function allow_ngo_uploads() {

    $b_role = get_role('rsmanager');
    $b_role->add_cap('read');
    $b_role->add_cap('upload_files');
    $b_role->add_cap('delete_posts');
    $b_role->add_cap('edit_posts');
    $b_role->add_cap( 'edit_others_posts' );
    $b_role->add_cap( 'edit_published_posts' );

    $c_role = get_role('client');
    $c_role->add_cap('read');
    $c_role->add_cap('upload_files');
    $c_role->add_cap('delete_posts');
  }
}

function custom_rewrite_rule() {
    add_rewrite_rule('^account/([^/]+)([/]?)(.*)','index.php?pagename=account&var1=$matches[1]&var2=$matches[3]','top');

}

function custom_rewrite_tag() {
  add_rewrite_tag('%var1%', '([^&]+)');
  add_rewrite_tag('%var2%', '([^&]+)');
}
add_action('init', 'custom_rewrite_tag', 10, 0);
add_filter('init', 'custom_rewrite_rule');

function disable_new_posts() {
  $user = current_user_data();
  if ( in_array( 'rsmanager', (array) $user->roles ) ) {
    // Hide sidebar link
    global $submenu;
    unset($submenu['edit.php?post_type=client'][10]);

    // Hide link on listing page
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'client') {
        echo '<style type="text/css">
        #favorite-actions, .add-new-h2, .tablenav { display:none; }
        .wrap .page-title-action{ display:none; }
        </style>';
    }
  }
}
add_action('admin_menu', 'disable_new_posts');

/* table crate hook*/
include_once(THEME_DIR .'/inc/account/table.php');
add_action('init', array('cbv_create_tables','create_tables'));