<?php 
/**
* Get the image tag with alt/title tag
*/
function cbv_get_image_tag( $id, $size = 'full', $title = false ){
	if( isset( $id ) ){
		$output = '';
		$image_title = get_the_title($id);
		$image_alt = get_post_meta( $id, '_wp_attachment_image_alt', true);
    if( empty( $image_alt ) ){
      $image_alt = $image_title;
    }
		$image_src = wp_get_attachment_image_src( $id, $size, false );

		if( $title ){
			$output = '<img src="'.$image_src[0].'" alt="'.$image_alt.'" title="'.$image_title.'">';
		}else{
			$output = '<img src="'.$image_src[0].'" alt="'.$image_alt.'">';
		}

		return $output;
	}
	return false;
}

/**
* Get the image src url by attachement it
*/
function cbv_get_image_src( $id, $size = 'full' ){
  if( isset( $id ) ){
    $afbeelding = wp_get_attachment_image_src($id, $size, false );
    if( is_array( $afbeelding ) && isset( $afbeelding[0] ) ){
      return $afbeelding[0];
    }
  }
  return false;
}
/**
* Get the image tag with alt/title tag
*/
function cbv_get_image_alt( $url ){
  if( isset( $url ) ){
    $output = '';
    $id = attachment_url_to_postid($url);
    $image_title = get_the_title($id);
    $image_alt = get_post_meta( $id, '_wp_attachment_image_alt', true);
    if( empty( $image_alt ) ){
      $image_alt = $image_title;
    }
    $image_alt = str_replace('-', ' ', $image_alt);
    $output = $image_alt;

    return $output;
  }
  return false;
}

function cbv_imagegrid( $image, $desc, $position = 'left' ){
	$output = '';
	if( !empty( $image ) && !empty( $desc ) ){
		$output = ( $position == 'left' ) ? 
			"<div class='df-text-rgt-img-grd-2 clearfix'>" : 
			"<div class='df-text-lft-img-grd-2 clearfix'>";
		$output .= '<div>' .cbv_get_image_tag( $image ). '</div>';
		$output .= '<div>' .wpautop( $desc ). '</div>';
		$output .= "</div>";
	}
	return $output;
}
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function phone_preg(){
  $spacialArry = array(".", "/", "+", " ");
  return $spacialArry;
}

function array_insert(&$array, $position, $insert_arr)
{
    if (is_int($position)) {
        return array_merge(array_slice($array, 0, $position), $insert_arr, array_slice($array, $position));
    }
    return false;
}

/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wpdocs_codex_client_init() {
    $labels = array(
        'name'                  => _x( 'Clients', 'Post type general name', THEME_NAME ),
        'singular_name'         => _x( 'Client', 'Post type singular name', THEME_NAME ),
        'menu_name'             => _x( 'Clients', 'Admin Menu text', THEME_NAME ),
        'name_admin_bar'        => _x( 'Client', 'Add New on Toolbar', THEME_NAME ),
        'add_new'               => __( 'Add New', THEME_NAME ),
        'add_new_item'          => __( 'Add New Client', THEME_NAME ),
        'new_item'              => __( 'New Client', THEME_NAME ),
        'edit_item'             => __( 'Edit Client', THEME_NAME ),
        'view_item'             => __( 'View Client', THEME_NAME ),
        'all_items'             => __( 'All Clients', THEME_NAME ),
        'search_items'          => __( 'Search Clients', THEME_NAME ),
        'parent_item_colon'     => __( 'Parent Clients:', THEME_NAME ),
        'not_found'             => __( 'No clients found.', THEME_NAME ),
        'not_found_in_trash'    => __( 'No clients found in Trash.', THEME_NAME )
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'client' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title' ),
    );
 
    register_post_type( 'client', $args );
}
 
add_action( 'init', 'wpdocs_codex_client_init' );

function insertLoginPage(){
  if ( get_page_by_title('Login') == null) {
     $my_post = array(
        'post_title'    => wp_strip_all_tags( 'Login' ),
        'post_content'  => '[login]',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'page',
      );
      wp_insert_post( $my_post );
  }
}