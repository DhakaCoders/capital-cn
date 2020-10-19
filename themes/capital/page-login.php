<?php 
get_header('logged');
global $login_errors; 
$emailindex = '';
if( isset($_POST['email']) && !empty($_POST['email']) ){
  $emailindex = $_POST['email'];
}
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="assets/images/sections-rgt-icon.png"></span>
  <div class="login-page-cntlr">
    
    <section class="login-form-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="login-form-cntlr">
              <span class="login-top-rt-icon">
                  <img src="assets/images/login-top-rt-icon.svg" alt="">
                </span>
                <span class="login-btm-lft-icon">
                  <img src="assets/images/login-btm-left-icon.svg" alt="">
                </span>
              <div class="login-form">
                <h1 class="form-title">Client Log in</h1>
                <form action="" method="POST">
                  <div class="input-row">
                    <input type="text" name="email" placeholder="Cliend ID" value="<?php echo $emailindex; ?>">
                    <i>
                      <img src="assets/images/login-user-icon.svg" alt="">
                    </i>
                  </div>
                  <div class="input-row">
                    <input type="password" name="password" placeholder="Password">
                    <i>
                      <img src="assets/images/login-pass-icon.svg" alt="">
                    </i>
                  </div>
                  <div class="input-row">
                    <input type="hidden" name="user_login_nonce" value="<?php echo wp_create_nonce('user-login-nonce'); ?>"/>
                    <input type="submit" name="submit" value="LOGIN">
                  </div>
                  <?php if( array_key_exists("loging_error", $login_errors) ): ?>
                  <div class="alert-msg">
                    <div class="unsuccess">
                      <?php printf('<p>%s</p>', $login_errors['loging_error']); ?>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="forget-pass">
                    <p>Forget <a href="#" target="_blank">Password</a>?</p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>    
    </section>


  </div>
</div>
<?php get_footer(); ?>