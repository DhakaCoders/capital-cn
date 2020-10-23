<?php $smedias = get_field('socialmedia', 'options'); ?>
<?php 
  global $wp_query, $wpdb;
  $user_data = current_user_data();
  $topic = $wp_query->get( 'var1' );
  $thisID = $clientpostID = '';
  if ( in_array( 'client', (array) $user_data->roles ) && is_user_logged_in() ) { 
    $curuserpost = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_author = '$user_data->ID' AND post_type = 'client' " );
    if( $curuserpost ){
      $thisID = $curuserpost->ID;
    } 

  }elseif ( in_array( 'rsmanager', (array) $user_data->roles ) && is_user_logged_in() ){
    if( isset($topic) && !empty($topic) && $topic == 'client'):
      $authorid = $wp_query->get( 'var2' );
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
        <li><a href="#">inbox</a></li>
        <?php 
          if( !empty($thisID) ):
            $consoltplan_status = get_field('draftpublish', $thisID);
            if( $consoltplan_status ):
              echo '<li><a href="'.esc_url( home_url('account/consultancy-plan/') ).'">consultancy plans </a></li>'; 
            else:
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b26500cd63') ).'">consultancy plans </a></li>'; 
            endif; 
          endif; 
        ?>
        <li><a href="<?php echo esc_url( home_url('account/request/') );?>">requests</a></li>
        <?php 
          if( !empty($thisID) ):
            $consult_status = get_field('draftpublishconsult', $thisID);
            if( $consult_status ): 
              echo '<li><a href="'.esc_url( home_url('account/consultations/') ).'">consultations</a></li>'; 
            else:
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">consultations</a></li>'; 
            endif; 
          endif; 

          if( !empty($thisID) ):
            $training_status = get_field('draftpublishtraining', $thisID);
            if( $training_status ): 
              echo '<li><a href="'.esc_url( home_url('account/trainings/') ).'">Training</a></li>'; 
            else:
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">Training</a></li>'; 
            endif; 
          endif; 

          if( !empty($thisID) ):
            $resources_status = get_field('draftpublishresources', $thisID);
            if( $resources_status ):
              echo '<li><a href="'.esc_url( home_url('account/resources/') ).'">resources</a></li>'; 
            else:
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">resources</a></li>'; 
            endif; 
          endif;

          if( !empty($thisID) ):
            $files_status = get_field('draftpublishfiles', $thisID);
            if( $files_status ):
              echo '<li><a href="'.esc_url( home_url('account/files/') ).'">Files</a></li>'; 
            else:
              echo '<li><a href="'.esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b27c7c87cd') ).'">Files</a></li>'; 
            endif; 
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