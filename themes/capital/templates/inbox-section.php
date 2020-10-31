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
                <div class="get_messages">
                  <span><?php echo $receiver_data->display_name; ?></span>
                  <hr/>
                  <div id="get_messages">
                    
                  </div>
                </div>
                <form class="form" id="user_conversation" onsubmit="userConversationFormData(); return false">
                  <input type="hidden" name="action" value="user_conversation_data">
                  <input type="hidden" name="receiver_id" id="receiverid" value="<?php echo $receiver_id; ?>">
                  <div class="cnt-btn">
                    <input type="hidden" name="user_conversation_nonce" value="<?php echo wp_create_nonce('user-conversation-nonce'); ?>"/>
                    <div class="inputFields-row">
                      <div class="inputField">
                        <input type="text" name="message" id="message" placeholder="Write a message...">
                      </div>
                    </div>
                    <input type="submit" value="SEND">
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
<div id="others-clients" data-more-ti="<?php echo $clientImpIDs; ?>"></div>
<div id="has-chat" data-ti="<?php echo $clientCurrentID; ?>"></div>
<?php 
$climg = get_user_image_url($clientCurrentID);
?>
<style type="text/css">
  .wcContainer .wcMessagesContainerTab.wcMessagesContainerTabActive:after{
    background: url(<?php echo $climg; ?>);
  }
</style>
