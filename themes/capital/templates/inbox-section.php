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
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="requests-page-cntlr">

      <section class="requests-sec">
        <div class="container">
          <div class="row">
            <div class="col-md-12">

            <div class="requests-sec-inr clearfix">
<div class="userChatBox">
<?php 
if (function_exists('wise_chat')) { wise_chat(); }
?>
</div>
            </div>
            </div>
          </div>
        </div>
      </section>
  </div>
</div>
<div id="others-clients" data-more-ti="<?php echo $clientImpIDs; ?>"></div>
<div id="has-chat" data-ti="<?php echo $clientCurrentID; ?>"></div>
