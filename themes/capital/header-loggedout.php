<?php 
  wpCheckLoggedin();
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
$logoObj = get_field('hdlogo', 'options');
if( is_array($logoObj) ){
  $logo_tag = '<img src="'.$logoObj['url'].'" alt="'.$logoObj['alt'].'" title="'.$logoObj['title'].'">';
}else{
  $logo_tag = '';
}
$smedias = get_field('socialmedia', 'options');
?>
<header class="header">
  <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header-inr clearfix">
            <div class="hdr-lft">
              <div class="hdr-social">
              <?php if(!empty($smedias)): ?>
                <ul class="reset-list">
                  <?php foreach($smedias as $smedia): ?>
                  <li>
                    <a target="_blank" href="<?php echo $smedia['url']; ?>">
                      <?php echo $smedia['icon']; ?>
                    </a>
                  </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              </div>
            </div>
            <div class="hdr-mid">
              <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                  <?php echo $logo_tag; ?>
                </a>
              </div>
            </div>
            <div class="hdr-rgt">
              <a class="hdr-login-btn" href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-sign-in-alt"></i>login</a>
            </div>
          </div>
        </div>
      </div>
  </div>
</header>