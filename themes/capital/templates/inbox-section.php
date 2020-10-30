<?php 
  global $wp_query, $wpdb;
  $user_data = current_user_data();
  $clientCurrentID = $wp_query->get( 'var2' );
  if( empty($clientCurrentID) ) { echo '<script> location.replace("'.home_url().'"); </script>'; exit(); }

$clientImpIDs = '';
if ( current_user_can( 'rsmanager' ) && is_user_logged_in() ){
  $cients = get_users(
    array(
      'meta_key' => 'accesspermission',
      'meta_value' => $user_data->ID
    )
  );
  $clientIDs = array();
  if( $cients ){
    foreach( $cients as $cient ): 
      if( $clientCurrentID != $cient->ID ){
        $clientIDs[] = $cient->ID;
      }
    endforeach;
    $clientImpIDs = implode(',', $clientIDs);
  }
}
$climg = get_user_image_url($clientCurrentID);

$user_info1 = get_userdata($clientCurrentID);
$user_roles = $user_info1->roles;
$isClient = false;
if (in_array("rsmanager", $user_roles)){
  $isClient = false;
}else{
  $isClient = true;
}

$user_info = get_user_meta($clientCurrentID);
$f_name = $user_info['first_name'][0];
$company_name = $user_info['company_name'][0];
$description = $user_info['description'][0];
//printr($user_info1);
?>
<div class="sections-cntlr login-page">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="inbox-page-cntlr">
    
    <section class="inbox-page-sec">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="inbox-page-sec-lft">
              <div class="cp-entry-hdr">
                <h1 class="cp-entry-hdr-title">Messages</h1>
              </div>
              <div class="msg-avater-info">
                <div class="msg-avater-info-inr">
                  <div class="msg-avater-pro">
                    <img src="<?php echo $climg; ?>">
                  </div>
                  <div class="msg-avater-des">
                    <strong><?php echo $f_name; ?></strong>
                    <div>
                      <?php if($isClient) {?>
                      <span></span><strong><?php echo $company_name; ?></strong>
                      <?php }else{ ?>
                      <span>CAPITAL EDVANTAGE </span> / <strong>CLIENT MANAGER</strong>
                      <?php } ?>
                    </div>
                    <p><?php echo $description; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
<div class="userChatBox">
<?php 
if (function_exists('wise_chat')) { wise_chat(); }
?>
</div>
          </div>
        </div>
      </div>    
    </section>


  </div>
</div>

<div id="others-clients" data-more-ti="<?php echo $clientImpIDs; ?>"></div>
<div id="has-chat" data-ti="<?php echo $clientCurrentID; ?>"></div>
<style type="text/css">
  .wcContainer .wcMessagesContainerTab.wcMessagesContainerTabActive:after{
    background: url(<?php echo $climg; ?>);
  }
</style>
