<?php

namespace YoBro\App;

class BBPressBuddyPress {
	public function __construct() {
		add_action( 'bbp_template_after_user_details', array( &$this, 'bbp_template_after_user_profile' ));
		add_action( 'bp_setup_nav', array( &$this, 'yobro_bb_custom_profile_tab'));
	}

	public function yobro_bb_custom_profile_tab() {
		if (is_user_logged_in()) {
			if(bp_displayed_user_id() == get_current_user_id()){
				bp_core_new_nav_item(
		    array(
		        'name' => '<div id="yobro-notification" data-bbp="true"></div>',
		        'slug' => 'yobro-bb-nav',
						'screen_function' => false,
		    ));
			}

			if(bp_displayed_user_id() != get_current_user_id()) {
				bp_core_new_nav_item(
		    array(
		        'name' => '<div id="yobro-new-message" class="buddypressCustom" data-id="' .bp_displayed_user_id(). '"></div>',
		        'slug' => 'yobro-bb-nav-new-message',
						'screen_function' => false,
		    ));
			}
		}
	}

	public function bbp_template_after_user_profile() {
		if (is_user_logged_in()) {
			if(bbp_get_user_id( 0, true, false ) !=  get_current_user_id()){
				$user_id = bbp_get_user_id();
				?>
				<script>
					jQuery('#bbp-user-navigation').append('<li><div id="yobro-new-message" class="yoBroBBPressNewMsg" data-id="<?php echo $user_id ?>">Send Message</div></li>');
				</script>
				<?php
			}else{
				?>
				<script>
					jQuery('#bbp-user-navigation').append('<li><div id="yobro-notification" data-bbp="true">Chat</div></li>');
				</script>
				<?php
			}
		}
	}
}
