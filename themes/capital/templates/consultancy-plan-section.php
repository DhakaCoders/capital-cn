<?php 
  $user_data = current_user_data();
  if( !$user_data ) redirect_page_notfound();
?>

<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="cnstncy-plan-page-cntlr">
    <section class="consultancy-plan-content">
      <div class="container">
        <?php  
          $args = array(
            'post_type' => 'client',
            'posts_per_page' => 1,
            'author' => $user_data->ID
          );
          $query = new WP_Query($args);
          if( $query->have_posts() ):
          while( $query->have_posts() ): $query->the_post();
            $draftpublish = get_field('draftpublish', get_the_ID());
            if( $draftpublish ):
            $consultplan = get_field('consultancyplan', get_the_ID());
            $plans = $consultplan['consultancy'];
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="cnstncy-plan-inr">
              <h1 class="cnstncy-plan-title">Consultancy Plan</h1>
              <?php if( $consultplan ): ?>
              <div class="cnstncy-plan-hdr">
                <ul class="reset-list">
                  <li>
                    <div class="cnstncy-plan-hdr-item">
                      <label>STRUCTURE NAME:</label>
                      <?php if( !empty($consultplan['structure_name']) ) printf('<div><strong>%s</strong></div>', $consultplan['structure_name']); ?>
                    </div>
                  </li>
                  <li>
                    <div class="cnstncy-plan-hdr-item">
                      <label>CONSULTANCY LENGTH:</label>
                      <div>
                        <strong>8 Weeks <?php if( !empty($consultplan['consultancy_length']) ) printf('<span>(%s)</span>', $consultplan['consultancy_length']); ?></strong>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="cnstncy-plan-hdr-item cicc-hdr-item">
                      <label>RELATIONSHIP MANAGER:</label>
                      <div>
                        <i><img src="<?php echo THEME_URI; ?>/assets/images/cicc-user-profile-photo-01.png"></i>
                        <strong>Jane Bishop</strong>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <?php if( $plans ): ?>
              <div class="cnstncy-plan-items">
                <ul class="reset-list">
                  <?php 
                    foreach( $plans as $plan ):
                    $blockshowhide =  $plan['blockshowhide'];
                    if( $blockshowhide ):
                  ?>
                  <li>
                    <div class="cnstncy-plan-item-cntlr">
                     <div class="cnstncy-plan-item mHc">
                      <div class="cnstncy-item-col-des">
                        <?php 
                          if( !empty($plan['title']) ) printf('<h3 class="cnstncy-item-title">%s</h3>', $plan['title']); 
                          if( !empty($plan['description']) ) echo wpautop( $plan['description'] ); 
                        ?>
                        <?php if( !empty($plan['status']) ) printf('<h6 class="cnstncy-item-sub-title">STATUS: <span>%s</span></h6>', $plan['status']); ?>
                      </div>
                      <?php 
                        $files = $plan['import_file']; 
                        if( $files ):
                          $filesize = round($files['filesize']/1024, 2);
                      ?>
                      <div class="cnstncy-item-col-lft">
                        <i><img src="<?php echo THEME_URI; ?>/assets/images/file-pdf-icon.svg"></i>
                        <div class="cnstncy-download-btn">
                          <a href="<?php echo $files['url']; ?>" download>DOWNLOAD</a>
                        </div>
                        <?php if( !empty($filesize) ) printf( '<span>(%skb)</span>', $filesize ); ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
              <?php endif; ?>
            </div>
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
              <div class="cnstncy-plan-inr">
                <p>No Results</p>
              </div>
            </div>
          </div>
        <?php endif; wp_reset_postdata(); ?>
      </div>
    </section>
  </div>
</div>