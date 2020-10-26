<?php $receiver_data = get_user_by('id', 7);?>
<div class="requests-sec-inr clearfix">
  <div class="requests-sec-lft">
    <div class="requests-sec-lft-inr">
      <div class="requests-sec-entry-hdr">
        <h1 class="rseh-title">Inbox</h1>
      </div>
      <div class="requests-sec-lft-des">
        <h3 class="rsld-title">This is a heading that spans two lines and is used for the client</h3>
        <p>Nam at scelerisque ligula, vel vulputate urna. Maecenas ut laoreet diam. Quisque fermentum gravida accumsan. Vivamus lacus massa, sollicitudin in viverra non, faucibus non dui. <br> Sed pretium at nulla ac finibus. In dignissim efficitur nisi, quis malesuada erat feugiat a. Nunc quis dui diam.</p>
      </div>
    </div>
  </div>
  <div class="requests-sec-rgt">
    <div class="requests-sec-form">
      <div class="get_messages">
        <span><?php echo $receiver_data->display_name; ?></span>
        <hr/>
        <div id="get_messages">
          
        </div>
      </div>
      <form class="form" id="user_conversation" onsubmit="userConversationFormData(); return false">
        <input type="hidden" name="action" value="user_conversation_data">
        <input type="hidden" name="receiver_id" id="receiverid" value="<?php echo $receiver_data->ID; ?>">
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