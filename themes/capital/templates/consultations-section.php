<?php 
  $user_data = current_user_data();
  if( !$user_data ) redirect_page_notfound();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="consultation-page-cntlr">
    <section class="cn-page-con">
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
              $draftpublish = get_field('draftpublishconsult', get_the_ID());
              if( $draftpublish ):
              $consulttypes = get_field('consultationstype', get_the_ID()); 
          ?>
          <div class="row">
            <div class="col-md-12">
              <div class="cp-entry-hdr">
                <h1 class="cp-entry-hdr-title">Consultation</h1>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="consultation-items">
                <?php 
                if( $consulttypes ):
                foreach( $consulttypes as $consulttype ): 
                  $consults = $consulttype['consultations'];
                  $showhideconsult = $consulttype['showhideconsultblock'];
                  if( $showhideconsult ):
                ?>
                <div class="consultation-item">
                  <div class="consultation-item-hdr">
                    <ul class="reset-list">
                      <li>
                        <div><label>DATE:</label>
                          <?php if( !empty($consulttype['date']) ) printf('<strong>%s</strong>', $consulttype['date']); ?>
                        </div>
                      </li>
                      <li>
                        <div><label>EMPLOYEE NAME:</label>
                          <?php if( !empty($consulttype['title']) ) printf('<strong>%s</strong>', $consulttype['title']); ?>
                        </div>
                      </li>
                      <li>
                        <div><label>STATUS:</label>
                          <?php if( !empty($consulttype['status']) ) printf('<strong>%s</strong>', $consulttype['status']); ?>
                        </div>
                      </li>
                    </ul>
                  </div>
                  
                  <div class="consultation-item-con-cntlr">
                    <div class="cicc-hdr">
                        <strong>URGENCY: <?php if( !empty($consulttype['urgency']) ) printf('<span>%s</span>', $consulttype['urgency']); ?></strong> 
                        <strong>CONSULTATION TYPE: <?php if( !empty($consulttype['title']) ) printf('<span>%s</span>', $consulttype['title']); ?></strong>
                    </div>
                    <?php if( $consults ): ?>
                    <div class="cicc-pdfs">
                      <ul class="reset-list clearfix">
                        <?php 
                          foreach( $consults as $consult ):
                          $showhidefileblock = $consult['showhidefileblock'];
                          if( $showhidefileblock ): 
                        ?>
                        <li>
                          <div class="cicc-pdf-col mHc clearfix">
                            <?php 
                              $files = $consult['import_file']; 
                              if( $files ):
                                $filesize = round($files['filesize']/1024, 2);
                            ?>
                            <div class="cicc-pdf-col-lft">
                              <i><img src="<?php echo THEME_URI; ?>/assets/images/file-icon.png"></i>
                              <div class="cicc-download-btn">
                                <a href="<?php echo $files['url']; ?>" download>DOWNLOAD</a>
                              </div>
                              <?php if( !empty($filesize) ) printf( '<span>(%skb)</span>', round($filesize) ); ?>
                            </div>
                            <?php endif; ?>
                            <div class="cicc-pdf-col-des">
                              <?php 
                              if( !empty($consult['title']) ) printf('<h6 class="ciccpcd-title">%s</h6>', $consult['title']); 
                              if( !empty($consult['description']) ) echo wpautop($consult['description']);
                              ?>
                            </div>
                          </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="consultation-item-close">
                    <strong>CLOSE</strong>
                  </div>
                  <div class="consultation-item-open">
                    <strong>OPEN</strong>
                  </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
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