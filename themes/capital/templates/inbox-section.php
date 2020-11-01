<?php 
  global $wp_query, $wpdb;
  $user_data = current_user_data();
  $receiverID = $wp_query->get( 'var2' );
  if( empty($receiverID) ) { echo '<script> location.replace("'.home_url().'"); </script>'; exit(); }

$clientImpIDs = '';
if ( current_user_can( 'rsmanager' )){
  $cients = get_users(
    array(
      'meta_key' => 'accesspermission',
      'meta_value' => $user_data->ID
    )
  );
  $clientIDs = array();
  if( $cients ){
    foreach( $cients as $cient ): 
      if( $receiverID != $cient->ID ){
        $clientIDs[] = $cient->ID;
      }
    endforeach;
    $clientImpIDs = implode(',', $clientIDs);
  }
}
  $receiver_data = get_user_by('id', $receiverID);
  $receiver_img = get_user_image_url($receiverID);
?>
<div class="sections-cntlr" id="check_chat">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="requests-page-cntlr">

      <section class="requests-sec">
        <div class="container">
          <div class="row">
            <div class="col-md-12">

            <div class="requests-sec-inr clearfix">
              <div class="userChatBox">
                <div class="get_messages">
                  <div class="message-top">
                    <div class="recever-img" style="background: url(<?php echo $receiver_img; ?>);"></div>
                    <span><?php echo $receiver_data->display_name; ?></span>
                  </div>
                  <div id="get_messages">
                    
                  </div>
                </div>
                <form class="form" id="user_conversation" onsubmit="userConversationFormData(); return false">
                  <input type="hidden" name="action" value="user_conversation_data">
                  <input type="hidden" name="status_check" id="status_check" value="read">
                  <input type="hidden" name="receiver_id" id="receiverid" value="<?php echo $receiverID; ?>">
                  <div class="cnt-btn">
                    <input type="hidden" name="user_conversation_nonce" value="<?php echo wp_create_nonce('user-conversation-nonce'); ?>"/>
                    <div class="inputFields-row">
                      <div class="inputField message-box">
                        <input type="text" name="message" id="message" placeholder="Write a message...">
                        <input type="submit" class="send-btn" value="SEND">
                      </div>
                    </div>
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
