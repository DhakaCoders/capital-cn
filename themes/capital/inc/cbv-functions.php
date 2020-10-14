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
