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


// Add the custom columns to the book post type:
add_filter( 'manage_client_posts_columns', 'set_custom_edit_book_columns' );
function set_custom_edit_book_columns($columns) {
    unset( $columns['date'] );
    $columns['client_manager'] = __( '', 'your_text_domain' );
    $columns['date'] = __( 'Date', 'your_text_domain' );
    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_client_posts_custom_column' , 'custom_book_column', 10, 3 );
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {
        case 'client_manager' :
        	$users = get_post_meta( $post_id , 'accesspermission' , true );
            //echo '<div>'.var_dump($users).'</div>'; 
        break;

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
  if ( in_array( 'rsmanager', (array) $user->roles ) ) {
    // Get the post type
    $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    if ( is_admin() && $pagenow=='edit.php' && $post_type == 'client' ) {
      $query->query_vars['meta_key'] = 'accesspermission';
      $query->query_vars['meta_value'] = serialize( strval( $user->ID ) );
      $query->query_vars['meta_compare'] = 'LIKE';
    }
  }
}
add_filter( 'parse_query', 'wisdom_sort_plugins_by_slug' );