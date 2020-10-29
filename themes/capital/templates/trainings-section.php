<?php 
  $user_data = current_user_data();
  if( !$user_data ) redirect_page_notfound();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="training-page-cntlr">
    
    <section class="tn-page-con">
      <div class="container">
        <?php 
          if( $user_data ){ 
          $args = array(
            'post_type' => 'client',
            'posts_per_page' => 1,
            'author' => $user_data->ID
          );
          $query = new WP_Query($args);
          if( $query->have_posts() ):
          while( $query->have_posts() ): $query->the_post();
            $draftpublish = get_field('draftpublishtraining', get_the_ID());
            if( $draftpublish ):
            $trainings = get_field('trainingstopic', get_the_ID());
            
        ?>
          <div class="row">
            <div class="col-md-12">
              <div class="cp-entry-hdr">
                <h1 class="cp-entry-hdr-title">Training</h1>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <?php if( $trainings ): ?>
              <div class="training-items">
                <ul class="reset-list clearfix">
                  <?php 
                    foreach( $trainings as $training ):
                    $showhidetraining = $training['showhidetraining'];
                    if( $showhidetraining ): 
                  ?>
                  <li>
                    <div class="training-item">
                      <div class="training-hdr">
                        <strong><?php if( !empty($training['title']) ) printf('%s', $training['title']); ?></strong>
                        <STRONG>DATE: <?php if( !empty($training['date']) ) printf('<span>%s</span>', $training['date']); ?></STRONG>
                      </div>
                      <div class="training-item-inr">
                        <div class="training-item-lft">
                          <div class="training-item-lft-avater">
                            <i>
                            <?php 
                              $managerID = get_user_meta( $user_data->ID, 'accesspermission', true );
                              $manager_data = get_user_by('id', $managerID);
                              $imageID = get_user_meta($manager_data->ID, 'profileimage', true);
                              if( isset($imageID) && !empty($imageID)){
                                echo cbv_get_image_tag( $imageID);
                              }else{
                                echo '';
                              }
                            ?>
                            </i>
                            <div>
                              <label>PREPARED BY:</label>
                              <strong>
                              <?php
                                if(!empty($manager_data->display_name)){
                                  echo $manager_data->display_name;
                                }else{
                                  echo $manager_data->user_nicename;
                                }
                              ?>
                              </strong>
                            </div>
                          </div>
                        </div>
                        <div class="training-item-des">
                          <?php 
                            if( !empty($training['description']) ) echo wpautop($training['description']); 
                            $trainfiles = $training['import_files'];
                            if( $trainfiles ):
                          ?>
                          <div class="training-item-des-pdf-list-items clearfix">
                            <?php 
                            foreach( $trainfiles as $trainfile ): 
                              $showhidefile = $trainfile['showhidefile'];
                              if( $showhidefile ): 
                              $files = $trainfile['addfile']; 
                              if( $files ):
                              $filesize = round($files['filesize']/1024, 2);
                            ?>
                            <div class="tidpl-item">
                              <i><img src="<?php echo THEME_URI; ?>/assets/images/file-icon.png"></i>
                              <div class="tidpl-item-des">
                                <strong>
                                  <?php 
                                    if( !empty($files['filename']) ) printf( '%s ', $files['filename'] ); 
                                    if( !empty($filesize) ) printf( '<span>(%skb)</span>', round($filesize) ); 
                                  ?>
                                </strong>
                                <a href="<?php echo $files['url']; ?>" download>download</a>
                              </div>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </li>
                  <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php 
            else: 
              redirect_page_notfound();
            endif; 
          ?>
          <?php endwhile; ?>
          <?php else: ?>
          <div class="row">
            <div class="col-md-12">
              <div class="training-items">
                <p>No Results</p>
              </div>
            </div>
          </div>
          <?php endif; wp_reset_postdata(); ?>
          <?php } ?>
      </div>    
    </section>


  </div>
</div>