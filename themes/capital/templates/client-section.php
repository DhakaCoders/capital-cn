<?php 
$user_data = current_user_data();
?>
<div class="sections-cntlr">
  <span class="sections-rgt-icon"><img src="<?php echo THEME_URI; ?>/assets/images/sections-rgt-icon.png"></span>
    <div class="files-page-cntlr">
      <section class="files-content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="files-content-inr">
                <div class="files-entry-hdr">
                  <h1 class="f-content-title">Client List</h1>
                </div>
                <div class="cp-search-row">
                  <form>
                    <input type="search" name="" placeholder="Search Client">
                    <button><i class="fas fa-search"></i></button>
                  </form>
                </div>
                <?php 
                  $cients = get_users(
                    array(
                      'meta_key' => 'accesspermission',
                      'meta_value' => $user_data->ID
                    )
                  );
                  //printr($cients);
                ?>
                <div class="clist-list-wrap">
                  <div class="clist-list">
                    <?php if( $cients ): ?>
                    <ul class="reset-list">
                      <?php foreach( $cients as $cient ): ?>
                      <li class="clearfix">
                        <div class="cl-profile clearfix">
                          <div class="cl-profile-in">
                            <?php 
                              $imageID = get_user_meta($cient->ID, 'profileimage', true);
                              if( isset($imageID) && !empty($imageID)){
                                echo cbv_get_image_tag( $imageID);
                              }else{
                                echo '';
                              }
                            ?>
                            <strong>
                              <?php
                                if(!empty($cient->display_name)){
                                  echo $cient->display_name;
                                }else{
                                  echo $cient->user_nicename;
                                }
                              ?>
                            </strong>
                          </div>
                        </div>
                        <?php $companyname = get_user_meta($cient->ID, 'company_name', true); ?>
                        <div class="cl-company"><span>Company Name:</span> <?php if( !empty($companyname) ) printf('%s', $companyname); ?></div>
                        <div class="cl-btn"><a href="<?php echo esc_url(home_url('account/client/'.$cient->ID)); ?>">LAUNCH</a></div>
                      </li>
                      <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                      <p>No Results</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>    
      </section>
  </div>
</div>