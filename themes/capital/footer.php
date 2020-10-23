<?php $copyright_text = get_field('copyright_text', 'options'); ?>
<footer class="footer-wrp">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
          <div class="ftr-cols">
            <div class="ftr-copyright">
              <?php if( !empty( $copyright_text ) ) printf( '<span>%s</span>', $copyright_text); ?> 
            </div>
            <div class="ftr-menu">
            <?php 
              $ftmenuOptions = array( 
                  'theme_location' => 'cbv_copyright_menu', 
                  'menu_class' => 'reset-list',
                  'container' => '',
                  'container_class' => ''
                );
              wp_nav_menu( $ftmenuOptions ); 
            ?> 
            </div>
          </div>
      </div>
    </div>
  </div> 
</footer>
<?php wp_footer(); ?>
</body>
</html>