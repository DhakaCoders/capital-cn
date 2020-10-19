<?php 
get_header(); 

$topic = $wp_query->get( 'topic' );
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
  }else{
    get_template_part( 'templates/main', 'section');
  }
}else{
  get_template_part( 'templates/main', 'section');
}
get_footer(); 
?>