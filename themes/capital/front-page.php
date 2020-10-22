<?php 
get_header(); 
$user_data = current_user_data();
$topic = $wp_query->get( 'topic' );
if( in_array( 'rsmanager', (array) $user_data->roles ) && is_user_logged_in() ){
    get_template_part( 'templates/client', 'section');
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
    }else{
      redirect_page_notfound();
    }
  }else{
    get_template_part( 'templates/main', 'section');
  }
}
get_footer(); 
?>