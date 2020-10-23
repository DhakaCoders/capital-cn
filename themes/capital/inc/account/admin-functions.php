<?php
add_action('user_register', 'add_client_post', 10, 1);      
function add_client_post( $user_id ) {    
    if( !empty($user_id) && isset( $_POST['first_name'] ) && !empty( $_POST['first_name'] )){
    	$user = get_user_by('id', $user_id);
    	if ( in_array( 'client', (array) $user->roles ) ) {
			$post_information = array(
				'post_author' => $user_id,
			    'post_title' => wp_strip_all_tags( $_POST['first_name'] ),
			    'post_content' => '',
			    'post_type' => 'client',
			    'post_status' => 'publish'
			);
			$post_id = wp_insert_post($post_information);
			if( $post_id ){
				$permission = get_user_meta( $user_id , 'accesspermission', true );
				if( isset( $permission ) && !empty( $permission ) ){
					update_post_meta( $post_id , 'accesspermission', $permission );
				}
			}
		}
    }
}
 
add_action('edit_user_profile_update','update_client_post', 10, 1 );  
function update_client_post( $user_id ) {   
	global $wpdb; 
    if( !empty($user_id) && isset( $_POST['first_name'] ) && !empty( $_POST['first_name'] )){
    	$user = get_user_by('id', $user_id);
    	if ( in_array( 'client', (array) $user->roles ) ) {
			$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_author = '$user_id' AND post_type = 'client' " ) );
			if( $data ){
				$post_information = array(
					'ID' =>  $data->ID,
					'post_author' => $user_id,
				    'post_title' => wp_strip_all_tags( $_POST['first_name'] ),
				    'post_type' => 'client'
				);
				 
				wp_update_post($post_information);
			}
		}

    }
}

if( isset( $_GET['user_id'] ) && !empty($_GET['user_id'])){
	submit_post_meta($_GET['user_id']);
}
function submit_post_meta($userid){
	global $wpdb;
	$user = get_user_by('id', $userid);
	if ( in_array( 'client', (array) $user->roles ) ) {
		$data = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_author = '$userid' AND post_type = 'client' " );
		$permission = get_user_meta( $userid , 'accesspermission', true );
		update_post_meta( $data->ID , 'accesspermission', $permission );
	}
}



 add_action( 'restrict_manage_posts', 'my_search_box' );
 function my_search_box() {
     // only add search box on desired custom post_type listings
     global $typenow;
     if ($typenow == 'client') {
       
     }
  }

  function wisdom_sort_plugins_by_slug( $query ) {
    global $pagenow;
    $user = current_user_data();
	if( $user ):
	  if ( in_array( 'rsmanager', (array) $user->roles ) ) {
	    // Get the post type
	    $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
	    if ( is_admin() && $pagenow=='edit.php' && $post_type == 'client' ) {
	      $query->query_vars['meta_key'] = 'accesspermission';
	      $query->query_vars['meta_value'] = $user->ID ;
	    }
	  }
	endif;
}
add_filter( 'parse_query', 'wisdom_sort_plugins_by_slug' );


function add_script_to_menu_page()
{
    global $pagenow;
 
    if ($pagenow != 'post.php') {
        return;
    }
     
    // loading css
    //wp_register_style( 'some-css', get_template_directory_uri() . '/css/some.css', false, '1.0.0' );
    //wp_enqueue_style( 'some-css' );
     
    // loading js
    wp_register_script( 'cbv-admin-js', get_template_directory_uri().'/assets/js/cbv-admin.js', array('jquery-core'), false, true );
    wp_enqueue_script( 'cbv-admin-js' );
}
 
add_action( 'admin_enqueue_scripts', 'add_script_to_menu_page' );


add_action('admin_footer', 'add_fronted_redirect_button');
function add_fronted_redirect_button(){
	$user_data = current_user_data();
	if ( in_array( 'rsmanager', (array) $user_data->roles ) && is_user_logged_in() ){
		$output = '';
		$output .='<div class="redirect-fronted"> <a href="'.esc_url( home_url('account/') ).'">Home</a> </div>';
		$output .='
		<style>
			.redirect-fronted {
			    position: fixed;
			    bottom: 90px;
			    right: 0px;
			    background: rgba(0,0,0,0.75);
			    padding: 10px 15px;
			}

			.redirect-fronted a {
			    color: #fff;
			    text-decoration: none;
			    font-size: 16px;
			    font-weight: 600;
			}
		</style>
		';
		echo $output;
	}
}

