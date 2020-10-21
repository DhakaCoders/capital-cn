<?php 
  $user_data = current_user_data();
  if( !$user_data ) redirect_page_notfound();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
    <div class="files-page-cntlr">
      <section class="files-content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="files-content-inr">
                <?php 
                  $args = array(
                    'post_type' => 'client',
                    'posts_per_page' => 1,
                    'author' => $user_data->ID
                  );
                  $query = new WP_Query($args);
                  if( $query->have_posts() ):
                  while( $query->have_posts() ): $query->the_post();
                    $draftpublish = get_field('draftpublishfiles', get_the_ID());
                    if( $draftpublish ):
                    $files = get_field('import_files', get_the_ID());
                ?>
                <div class="files-entry-hdr">
                  <h1 class="f-content-title">Files</h1>
                </div>
                <div class="cp-search-row">
                  <form>
                    <input type="search" name="" placeholder="Search Files">
                    <button><i class="fas fa-search"></i></button>
                  </form>
                </div>
                <div class="files-grid-items">
                  <?php if( $files ): ?>
                  <ul class="reset-list clearfix">
                    <?php 
                    foreach( $files as $file ): 
                      $pdf = $file['addfile']; 
                      $filesize = round($pdf['filesize']/1024, 2);
                    $showhidefiles = $file['showhidefiles'];
                    if( $showhidefiles ):
                    ?>
                    <li>
                      <div class="files-grd-item">
                        <div class="fgiwnld">
                          <div class="files-grd-item-dwnld-des">
                            <i>
                              <img src="<?php echo THEME_URI; ?>/assets/images/file-icon.png">
                            </i>
                            <div class="fgidwnld-date">
                              <label>DATE ADDED:</label>
                              <?php if( !empty($file['date']) ) printf( '<span>%s</span>', $file['date'] ); ?>
                            </div>
                            <div class="fgidwnld-file-ver">
                              <?php if( !empty($pdf['filename']) ) printf( '<strong>%s</strong>', $pdf['filename'] ); ?>
                            </div>
                            <div class="fgidwnld-size">
                              <?php if( !empty($filesize) ) printf( '<span>(%skb)</span>', $filesize ); ?>
                            </div>
                          </div>
                          <div class="files-grd-item-dwnld-link">
                            <a href="<?php echo $pdf['url']; ?>" download>DOWNLOAD</a>
                          </div>
                        </div>
                        <div class="fgicmd clearfix">
                          <div class="fgicmd-lft">
                            <div class="fgicmd-lft-img">
                              <i>
                                <img src="<?php echo THEME_URI; ?>/assets/images/files-msg-icon.svg">
                              </i>
                              <span>6</span>
                            </div>
                            <div class="fgicmd-lft-field">
                              <input type="text" placeholder="Read comments">
                            </div>
                          </div>
                          <div class="fgicmd-rgt">
                            <div class="fgicmd-rgt-upload">
                              <span>Uploaded by:</span>
                              <strong>Jane Bishop</strong>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                  <?php endif; ?>
                </div>
                <?php 
                  else: 
                    redirect_page_notfound();
                  endif; 
                ?>
              <?php endwhile; ?>
              <?php else: ?>

              <?php endif; wp_reset_postdata(); ?>
              </div>

            </div>
          </div>
        </div>    
      </section>
  </div>
</div>