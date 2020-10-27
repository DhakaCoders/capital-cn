<?php
/*
  Template Name: Set Password
*/ 
get_header('loggedout');
global $email_errors;
?>
<div class="sections-cntlr login-page">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="login-page-cntlr">
    
    <section class="login-form-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="login-form-cntlr">
              <span class="login-top-rt-icon">
                  <img src="<?php echo THEME_URI; ?>/assets/images/login-top-rt-icon.svg" alt="">
                </span>
                <span class="login-btm-lft-icon">
                  <img src="<?php echo THEME_URI; ?>/assets/images/login-btm-left-icon.svg" alt="">
                </span>
              <div class="login-form">
                <h1 class="form-title">New Password?</h1>
                <form action="" method="post" id="change_pass_form">
                  <div class="input-row">
                    <input type="hidden" name="token" value="<?php echo (isset($_GET['token']) && !empty($_GET['token']))? $_GET['token']: '';?>">
                    <input type="password" name="new_password" id="newpass" placeholder="New Password">
                    <i>
                      <img src="<?php echo THEME_URI; ?>/assets/images/login-pass-icon.svg" alt="">
                    </i>
                  </div>
                  <div class="input-row">
                    <input type="password" name="confirm_password" id="confpass" placeholder="Confirm Password">
                    <i>
                      <img src="<?php echo THEME_URI; ?>/assets/images/login-pass-icon.svg" alt="">
                    </i>
                  </div>
                  <div class="input-row">
                    <input type="hidden" name="set_password_nonce" value="<?php echo wp_create_nonce('set-password-nonce'); ?>"/>
                    <input type="submit" name="submit" value="CREATE NEW PASSWORD">
                  </div>
                  <div class="alert-msg">
                    <div class="pass-error-new">
                      <span class="error" style="color:red;display: block;"></span>
                    </div>
                    <?php if( array_key_exists("email_success", $email_errors) ): ?>
                    <div class="success">
                      <?php printf('<p>%s</p>', $email_errors['email_success']); ?>
                    </div>
                    <?php endif; ?>
                    <?php if( array_key_exists("email_error", $email_errors) ): ?>
                    <div class="unsuccess">
                      <?php printf('<p>%s</p>', $email_errors['email_error']); ?>
                    </div>
                    <?php 
                      endif;
                      unset($email_errors);
                    ?>
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