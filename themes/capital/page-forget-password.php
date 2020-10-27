<?php
/*
  Template Name: Forget Password
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
                <h1 class="form-title">Forgot Password?</h1>
                <form action="" method="post">
                  <div class="input-row">
                    <input type="email" name="exists_email" placeholder="Your email address" required="required">
                    <i>
                      <img src="<?php echo THEME_URI; ?>/assets/images/login-user-icon.svg" alt="">
                    </i>
                  </div>
                  <div class="input-row">
                    <input type="hidden" name="forget_password_nonce" value="<?php echo wp_create_nonce('forget-password-nonce'); ?>"/>
                    <input type="submit" name="submit" value="GET NEW PASSWORD">
                  </div>
                  <div class="alert-msg">
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