<?php 
$user_data = current_user_data();
if( !$user_data ) redirect_page_notfound();
$query = new WP_Query( array( 'post_type' => 'page', 'pagename' => 'edvantage-club' ) );
if( $query->have_posts() ):
while ( $query->have_posts() ):
        $query->the_post();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="edv-clb-page-cntlr">
    
    <section class="edvantage-club-content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="edv-clb-inr">
              <h1 class="edv-clb-title"><?php the_title()?></h1>
              <div class="edv-normal-cn">
                <?php the_content(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<?php 
endwhile;
endif;
wp_reset_postdata();
?>