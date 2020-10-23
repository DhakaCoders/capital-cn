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
              <ul class="reset-list">
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Cookies</a></li>
              </ul>
            </div>
          </div>
      </div>
    </div>
  </div> 
</footer>
<?php wp_footer(); ?>
</body>
</html>