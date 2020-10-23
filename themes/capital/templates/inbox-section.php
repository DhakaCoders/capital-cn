
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="requests-page-cntlr">

      <section class="requests-sec">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
            <?php 
              global $wp_query, $wpdb;
              $user_data = current_user_data();
              if ( in_array( 'client', (array) $user_data->roles ) && is_user_logged_in() ) { 
              $receiver_id = get_user_meta( $user_data->ID, 'accesspermission', true );
              $receiver_data = get_user_by('id', $receiver_id);
            ?>

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
                    <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
                    <div class="cnt-btn">
                      <input type="hidden" name="user_conversation_nonce" value="<?php echo wp_create_nonce('user-conversation-nonce'); ?>"/>
                      <div class="inputFields-row">
                        <div class="inputField">
                          <input type="text" name="message" placeholder="Write a message...">
                        </div>
                      </div>
                      <input type="submit" value="SEND">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php
              }elseif ( in_array( 'rsmanager', (array) $user_data->roles ) && is_user_logged_in() ){
                if( isset($topic) && !empty($topic) && $topic == 'client'):
                  $authorid = $wp_query->get( 'var2' );
                  if( isset($authorid) && !empty($authorid)){
                    $clientpost = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_author = '$authorid' AND post_type = 'client' " );
                    if( $clientpost ){
                      $clientpostID = $clientpost->ID;
                    }
                  }
                endif;
                $thisID = $user_data->ID;
            ?>

            <?php
              }
            ?>
            </div>
          </div>
        </div>
      </section>

    


  </div>
</div>