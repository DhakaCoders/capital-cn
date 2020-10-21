<?php 
  $user_data = current_user_data();
  $thisID = '';
  if ( in_array( 'client', (array) $user_data->roles ) && is_user_logged_in() ) { 
    $args = array(
      'post_type' => 'client',
      'posts_per_page' => 1,
      'author' => $user_data->ID
    );
    $query = new WP_Query($args);
    if( $query->have_posts() ):
    while( $query->have_posts() ): $query->the_post();
      $thisID = get_the_ID();
    endwhile; 
    endif;
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
                    <a href="#" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/inbox.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="#">inbox</a></h2>
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
                    <a href="<?php echo esc_url( home_url('topic/consultancy-plan/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultancy-plan-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/consultancy-plan/') );?>">CONSULTANCY PLAN</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  else: 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('topic/consultancy-plan/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultancy-plan-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/consultancy-plan/') );?>">CONSULTANCY PLAN</a></h2>
                    </div>
                  </div>
                </li>
                <?php endif; ?>
                
                <li>
                  <div class="content-item">
                    <a href="#" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/request-icon.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="#">request</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  if( !empty($thisID) ):
                  $consult_status = get_field('draftpublishconsult', $thisID);
                  if( $consult_status ): 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('topic/consultations/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/consultations.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/consultations/') );?>">consultations</a></h2>
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
                    <a href="<?php echo esc_url( home_url('topic/trainings/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/training.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/trainings/') );?>">training</a></h2>
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
                    <a href="<?php echo esc_url( home_url('topic/resources/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/resources.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/resources/') );?>">resources</a></h2>
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
                    <a href="<?php echo esc_url( home_url('topic/files/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/files.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/files/') );?>">files</a></h2>
                    </div>
                  </div>
                </li>
                <?php 
                  endif;
                  endif; 
                ?>
                <li>
                  <div class="content-item">
                    <a href="<?php echo esc_url( home_url('topic/edvantage-club/') );?>" class="overlay-link"></a>
                    <div class="content-item-icon mHc">
                      <img src="<?php echo THEME_URI; ?>/assets/images/club.svg" alt="">
                    </div>
                    <div class="content-item-hdng mHc1">
                      <h2 class="content-item-title"><a href="<?php echo esc_url( home_url('topic/edvantage-club/') );?>">EDVANTAGE CLUB</a></h2>
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