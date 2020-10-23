<?php 
$requests = get_field('requests', 'options'); 
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
  <div class="requests-page-cntlr">

      <section class="requests-sec">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="requests-sec-inr clearfix">
                <div class="requests-sec-lft">
                  <div class="requests-sec-lft-inr">
                    <div class="requests-sec-entry-hdr">
                      <h1 class="rseh-title">Requests</h1>
                    </div>
                    <div class="requests-sec-lft-des">
                      <?php if( $requests ): ?>
                      <?php 
                        if( !empty($requests['title']) ) printf('<h3 class="rsld-title">%s</h3>', $requests['title']); 
                        if( !empty($requests['description']) ) echo wpautop($requests['description']);
                      ?>
                      <?php endif; ?>
                      <div class="rsld-tel">
                        <i>
                          <img src="<?php echo THEME_URI; ?>/assets/images/rsld-tel.png">
                        </i>
                        <a href="tel:02514112233">02514 112233</a>
                        <a href="tel:07850740355">07850 740355</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="requests-sec-rgt">
                  <div class="requests-sec-form">
                    <form class="form" id="user_request" onsubmit="userRequestFormData(); return false">
                      <div class="inputFields-row">
                        <div class="inputField">
                          <div class="cp-select">
                            <select name="request_type" id="request_type" class="selectpicker">
                              <option value="">Request type</option>
                              <?php 
                                if( $requests ): 
                                  $rtypes = $requests['request_types'];
                                  if( $rtypes ):
                                  foreach( $rtypes as $rtype ):
                              ?>
                              <option value="<?php echo $rtype['type_title']; ?>"><?php echo $rtype['type_title']; ?></option>
                              <?php endforeach; ?>
                              <?php endif; endif; ?>
                            </select>
                            <input type="hidden" name="action" value="user_request_data">
                          </div>
                        </div>
                      </div>
                      <div class="inputFields-row">
                        <div class="inputField">
                          <textarea name="request_notes" id="request_notes" placeholder="Your notes"></textarea>
                        </div>
                      </div>
                      <div class="upload-file-btn">
                        <input type="file" name="request_file" id="request_file" value="UPLOAD A FILE">
                      </div>
                      <div class="cnt-btn">
                        <input type="hidden" name="user_request_nonce" value="<?php echo wp_create_nonce('user-request-nonce'); ?>"/>
                        <input type="submit" value="SEND REQUEST">
                      </div>
                      <div id="message"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    


  </div>
</div>