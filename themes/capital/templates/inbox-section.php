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
                  <div class="message-top">
                    <div class="recever-img" style="background: url(http://localhost/2020/10/capital/capital-cn/uploads/2020/10/big.jpg);"></div>
                    <span>Nmanager 1</span>
                  </div>
                  <div id="get_messages">
                    <div class="message-receiver">
                      <span class="chatavatar"></span>
                      <span class="mgs-time">5.30</span>
                      <span class="receiver">Hello</span>
                    </div>
                    <div class="message-receiver">
                      <span class="chatavatar"></span>
                      <span class="mgs-time">5.30</span>
                      <span class="receiver">how are you doing today?</span>
                    </div>
                    <div class="message-receiver">
                      <span class="chatavatar"></span>
                      <span class="mgs-time">5.30</span>
                      <span class="receiver">Is there everything ok?</span>
                    </div>
                    <div class="message-sender">
                      <span class="mgs-time">5.30</span>
                      <span class="sender">Hey, I am good thanks!</span>
                    </div>
                  </div>
                </div>
                <form class="form" id="user_conversation" onsubmit="userConversationFormData(); return false">
                  <input type="hidden" name="action" value="user_conversation_data">
                  <input type="hidden" name="receiver_id" id="receiverid" value="11">
                  <div class="cnt-btn">
                    <input type="hidden" name="user_conversation_nonce" value="32f51dc3f3">
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
