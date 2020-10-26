<?php 
 wpCheckloggetout();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
<head> 
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php $favicon = get_theme_mod('favicon'); if(!empty($favicon)) { ?> 
  <link rel="shortcut icon" href="<?php echo $favicon; ?>" />
  <?php } ?>
  <svg style="display: none;">

    
    <!-- end of Shoriful -->



    <!-- end of Noyon -->



    <!-- end of Rannojit -->
  </svg>
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->	
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
$user = wp_get_current_user();
?>
<?php 
$logoObj = get_field('hdlogo', 'options');
if( is_array($logoObj) ){
  $logo_tag = '<img src="'.$logoObj['url'].'" alt="'.$logoObj['alt'].'" title="'.$logoObj['title'].'">';
}else{
  $logo_tag = '';
}
?>
<header class="login-heder">
<div class="bdoverlay"></div>
  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="login-header-inr clearfix">
            <div class="login-hdr-lft">
              <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                  <?php echo $logo_tag; ?>
                </a>
              </div>
            </div>
            <div class="login-hdr-rgt">
              <div class="hdr-grd-item hdr-grd-item-01">
                <div>
                  <a href="#">
                    <img src="<?php echo THEME_URI; ?>/assets/images/message-icon.svg">
                    <span>6</span>
                  </a>
                </div>
              </div>
              <div class="hdr-grd-item hdr-grd-item-03">
                <div class="humbergur-btn">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>
              <div class="hdr-grd-item hdr-grd-item-04">
                <div class="hdr-user-cntlr">
                  <div class="hdr-user-toggle-btn">
                    <div class="user-photo">
                      <?php get_user_image(); ?>
                    </div>
                    <label><?php get_current_user_name(); ?></label>
                  </div>
                  <div class="hdr-user-toggle-menu">
                    <ul class="reset-list">
                      <?php if ( in_array( 'client', (array) $user->roles ) && is_user_logged_in() ) { ?>
                      <li><a href="<?php echo esc_url( home_url('account') ); ?>">My Profile</a></li>
                      <?php }else{ ?>
                      <li><a href="<?php echo esc_url( home_url('wp-admin') ); ?>">My Profile</a></li>
                      <?php } ?>
                      <li><a href="<?php get_custom_logout(); ?>">Logout</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

<?php get_template_part( 'templates/burger', 'menu'); ?>
</header>