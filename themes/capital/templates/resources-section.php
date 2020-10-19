<?php 
  $user_data = current_user_data();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="resources-page-cntlr">
    
    <section class="rs-page-con">
      <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="cp-entry-hdr">
                <h1 class="cp-entry-hdr-title">Resources</h1>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="cp-search-row">
                <form>
                  <input type="search" name=""  placeholder="Search Resources">
                  <button><i class="fas fa-search"></i></button>
                </form>
              </div>
            </div>
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
                  $draftpublish = get_field('draftpublishresources', get_the_ID());
                  $resources = get_field('resources', get_the_ID());
                  if( $resources && $draftpublish ):
              ?>
              <div class="cp-search-items">
                <ul class="reset-list clearfix">
                  <?php foreach( $resources as $resource ): ?>
                  <li>
                    <div class="cp-search-item clearfix">
                      <div class="cp-titleDesc">
                        <?php 
                          if( !empty($resource['title']) ) printf('<h6>%s</h6>', $resource['title']); 
                          if( !empty($resource['description']) ) echo wpautop($resource['description']);
                        ?>
                      </div>
                      <?php 
                        $files = $resource['import_file']; 
                        if( $files ):
                          $filesize = round($files['filesize']/1024, 2);
                      ?>
                      <div class="cp-search-item-pdf">
                        <div class="cicc-pdf-col-lft">
                          <i><img src="<?php echo THEME_URI; ?>/assets/images/file-icon.png"></i>
                          <div class="cicc-download-btn">
                            <a href="<?php echo $files['url']; ?>" download>DOWNLOAD</a>
                          </div>
                          <?php if( !empty($filesize) ) printf( '<span>(%skb)</span>', $filesize ); ?>
                        </div>
                      </div>
                      <?php endif; ?>
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