<?php $smedias = get_field('socialmedia', 'options'); ?>
<?php 
  global $wp_query, $wpdb;
  $user_data = current_user_data();
  $topic = $wp_query->get( 'var1' );
  $authorid = $wp_query->get( 'var2' );
  $thisID = $clientpostID = '';
  if ( current_user_can( 'client' ) && is_user_logged_in() ) { 
    $curuserpost = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_author = '$user_data->ID' AND post_type = 'client' " );
    if( $curuserpost ){
      $thisID = $curuserpost->ID;
    } 
    $authorid =  get_user_meta($user_data->ID, 'accesspermission', true);

  }elseif ( current_user_can( 'rsmanager' ) && is_user_logged_in() ){
    if( isset($topic) && !empty($topic) && $topic == 'client'):
      if( isset($authorid) && !empty($authorid)){
        $clientpost = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_author = '$authorid' AND post_type = 'client' " );
        if( $clientpost ){
          $clientpostID = $clientpost->ID;
        }
      }
    endif;
    $thisID = $user_data->ID;
  }
?>
<div class="menu-sidebar">
  <nav class="main-nav">
    <div class="main-nav-inr">
      <div class="closebtn">
        <i class="far fa-times-circle"></i>
        <span>close menu</span>
      </div>
      <ul class="clearfix reset-list">
        <li><a href="<?php echo esc_url( home_url('account') );?>">Home</a></li>
        <li><a href="<?php echo esc_url( home_url('account/inbox/'.$authorid) );?>">inbox</a></li>
        <?php 
          if( !empty($thisID) ):
            if ( current_user_can( 'client' )) { 
              $consoltplan_status = get_field('draftpublish', $thisID);
              if( $consoltplan_status ):
                echo '<li><a href="'.esc_url( home_url('account/consultancy-plan/') ).'">consultancy plans </a></li>'; 
              endif;
            }else{
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b26500cd63') ).'">consultancy plans </a></li>'; 
            }
          endif; 
        ?>
        <?php if ( current_user_can( 'client' )  && is_user_logged_in() ) { ?>
        <li><a href="<?php echo esc_url( home_url('account/request/') );?>">requests</a></li>
        <?php } ?>
        <?php 
          if( !empty($thisID) ):
            if ( current_user_can( 'client' )) { 
              $consult_status = get_field('draftpublishconsult', $thisID);
              if( $consult_status ): 
                echo '<li><a href="'.esc_url( home_url('account/consultations/') ).'">consultations</a></li>'; 
              endif;
            }else{
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">consultations</a></li>';  
            }
          endif; 

          if( !empty($thisID) ):
            if ( current_user_can( 'client' )) { 
              $training_status = get_field('draftpublishtraining', $thisID);
              if( $training_status ): 
                echo '<li><a href="'.esc_url( home_url('account/trainings/') ).'">Training</a></li>'; 
              endif;
            }else{
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">Training</a></li>'; 
            }
          endif; 

          if( !empty($thisID) ):
            if ( current_user_can( 'client' )) { 
              $resources_status = get_field('draftpublishresources', $thisID);
              if( $resources_status ):
                echo '<li><a href="'.esc_url( home_url('account/resources/') ).'">resources</a></li>'; 
              endif;
            }else{
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">resources</a></li>'; 
            }
          endif;

          if( !empty($thisID) ):
            if ( current_user_can( 'client' )) { 
              $files_status = get_field('draftpublishfiles', $thisID);
              if( $files_status ):
                echo '<li><a href="'.esc_url( home_url('account/files/') ).'">Files</a></li>'; 
              endif;
            }else{
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">Files</a></li>'; 
            }
          endif;
        ?>
        <li><a href="<?php echo esc_url( home_url('account/edvantage-club/') );?>">the edvantage club </a></li>
      </ul>
      <div class="hdr-social">
        <?php if(!empty($smedias)): ?>
          <ul class="reset-list">
            <?php foreach($smedias as $smedia): ?>
            <li>
              <a target="_blank" href="<?php echo $smedia['url']; ?>">
                <?php echo $smedia['icon']; ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
    
  </nav>
</div>