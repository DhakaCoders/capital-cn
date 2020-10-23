<?php 
/*
  Template Name: Account
*/
get_header(); 
global $wp_query;
$user_data = current_user_data();
$topic = $wp_query->get( 'var1' );

if( in_array( 'rsmanager', (array) $user_data->roles ) && is_user_logged_in() ){
    if( $topic == 'client'){
      get_template_part( 'templates/main', 'section');
    }elseif( $topic == 'inbox'){
      get_template_part( 'templates/inbox', 'section');
    }elseif( $topic == 'edvantage-club'){
      get_template_part( 'templates/edvantage-club', 'section');
    }else{
      get_template_part( 'templates/client', 'section');
    }
}else{
  if( isset($topic) && !empty($topic) ){
    if( $topic == 'consultancy-plan'){
      get_template_part( 'templates/consultancy-plan', 'section');
    }elseif( $topic == 'consultations'){
      get_template_part( 'templates/consultations', 'section');
    }elseif( $topic == 'resources'){
      get_template_part( 'templates/resources', 'section');
    }elseif( $topic == 'trainings'){
      get_template_part( 'templates/trainings', 'section');
    }elseif( $topic == 'files'){
      get_template_part( 'templates/files', 'section');
    }elseif( $topic == 'edvantage-club'){
      get_template_part( 'templates/edvantage-club', 'section');
    }elseif( $topic == 'request'){
      get_template_part( 'templates/request', 'section');
    }elseif( $topic == 'inbox'){
      get_template_part( 'templates/inbox', 'section');
    }elseif( $topic == 'client'){
      get_template_part( 'templates/main', 'section');
    }else{
      get_template_part( 'templates/main', 'section');
    }
  }else{
    get_template_part( 'templates/main', 'section');
  }
}
get_footer(); 
?>