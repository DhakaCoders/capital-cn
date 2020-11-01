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
                  <form id="clientform">
                    <input type="search" name="" id="clientinput" placeholder="Search Client">
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
                    <ul class="reset-list" id="clientlist">
                      <?php 
                      foreach( $cients as $cient ): 
                        if(!empty($cient->display_name)){
                          $clientname = $cient->display_name;
                        }else{
                          $clientname = $cient->user_nicename;
                        }
                        $keyword = str_replace(' ', '', $clientname);
                      ?>
                      <li class="clearfix <?php echo strtolower($keyword); ?>" >
                        <div class="cl-profile clearfix">
                          <div class="cl-profile-in">
                            <div class="cl-profile-img">
                            <?php 
                              if( isset($cient->ID) && !empty($cient->ID)){
                                echo get_user_image_tag($cient->ID);
                              }
                            ?>
                            </div>
                            <strong>
                              <?php
                                echo $clientname;
                              ?>
                            </strong>
                          </div>
                        </div>
                        <?php $companyname = get_user_meta($cient->ID, 'company_name', true); ?>
                        <div class="cl-company"><span>Company Name:</span> <?php if( !empty($companyname) ) printf('%s', $companyname); ?></div>
                        <div class="cl-status"><span>Status:</span> Planning</div>
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