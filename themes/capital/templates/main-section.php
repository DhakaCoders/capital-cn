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
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="home-page-cntlr">
    
    <section class="home-content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="h-content-inr">
              <ul class="reset-list">
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/inbox.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account') );?>">inbox</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  if( !empty($thisID) ):
                  $consoltplan_status = get_field('draftpublish', $thisID);
                  if( $consoltplan_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/consultancy-plan/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultancy-plan-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/consultancy-plan/') );?>">CONSULTANCY PLAN</a></h2>
                    </div>
                  </div>
                </li>
                <?php else: ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b26500cd63') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultancy-plan-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key=#field_5f8b26500cd63') );?>">CONSULTANCY PLAN</a></h2>
                    </div>
                  </div>
                </li>
                <?php endif; ?>
                <?php endif; ?>
                <?php if ( in_array( 'client', (array) $user_data->roles ) && is_user_logged_in() ) { ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/request/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/request-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/request/') );?>">request</a></h2>
                    </div>
                  </div>
                </li>
                <?php } ?>
                <?php 
                  if( !empty($thisID) ):
                  $consult_status = get_field('draftpublishconsult', $thisID);
                  if( $consult_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/consultations/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultations.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/consultations/') );?>">consultations</a></h2>
                    </div>
                  </div>
                </li>
                <?php else: ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key#field_5f8b27c7c87cd') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultations.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit&key#field_5f8b27c7c87cd') );?>">consultations</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  endif;
                ?>
                <?php 
                  if( !empty($thisID) ):
                  $training_status = get_field('draftpublishtraining', $thisID);
                  if( $training_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/trainings/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/training.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/trainings/') );?>">training</a></h2>
                    </div>
                  </div>
                </li>
                <?php else: ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/training.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>">training</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  endif; 
                ?>
                <?php 
                  if( !empty($thisID) ):
                  $resources_status = get_field('draftpublishresources', $thisID);
                  if( $resources_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/resources/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/resources.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/resources/') );?>">resources</a></h2>
                    </div>
                  </div>
                </li>
                <?php else: ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/resources.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>">resources</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  endif; 
                ?>
                <?php 
                  if( !empty($thisID) ):
                  $files_status = get_field('draftpublishfiles', $thisID);
                  if( $files_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/files/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/files.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/files/') );?>">files</a></h2>
                    </div>
                  </div>
                </li>
                <?php else: ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/files.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('wp-admin/post.php?post='.$clientpostID.'&action=edit') );?>">files</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  endif; 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('account/edvantage-club/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/club.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('account/edvantage-club/') );?>">EDVANTAGE CLUB</a></h2>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>    
    </section>


  </div>
</div>