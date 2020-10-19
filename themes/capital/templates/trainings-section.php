<?php 
  $user_data = current_user_data();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="training-page-cntlr">
    
    <section class="tn-page-con">
      <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="cp-entry-hdr">
                <h1 class="cp-entry-hdr-title">Training</h1>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
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
                  $trainings = get_field('trainingstopic', get_the_ID());
                  if( $trainings && $draftpublish ):
              ?>
              <div class="training-items">
                <ul class="reset-list clearfix">
                  <?php foreach( $trainings as $training ): ?>
                  <li>
                    <div class="training-item">
                      <div class="training-hdr">
                        <strong><?php if( !empty($training['title']) ) printf('%s', $training['title']); ?></strong>
                        <STRONG>DATE: <?php if( !empty($training['date']) ) printf('<span>%s</span>', $training['date']); ?></STRONG>
                      </div>
                      <div class="training-item-inr">
                        <div class="training-item-lft">
                          <div class="training-item-lft-avater">
                            <i><img src="<?php echo THEME_URI; ?>/assets/images/cicc-user-profile-photo-01.png"></i>
                            <div>
                              <label>PREPARED BY:</label>
                              <strong>Jane Bishop</strong>
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
                                    if( !empty($filesize) ) printf( '<span>(%skb)</span>', $filesize ); 
                                  ?>
                                </strong>
                                <a href="<?php echo $files['url']; ?>" download>download</a>
                              </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
              <?php endwhile; ?>
              <?php else: ?>

              <?php endif; wp_reset_postdata(); ?>
              <?php } ?>
            </div>
          </div>
      </div>    
    </section>


  </div>
</div>