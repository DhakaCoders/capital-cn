<?php
// if this fails, check_admin_referer() will automatically print a "failed" page and die.
if ( ! empty( $_POST ) && check_admin_referer( 'nonce_yo_bro_settings', 'yo_bro_settings' ) ) {
	$posted = $_POST;
	unset($posted['submit']);
	unset($posted['yo_bro_settings']);
	unset($posted['_wp_http_referer']);
	update_option('yo_bro_settings', $posted);
}

$yo_bro_settings = get_option('yo_bro_settings', true);
?>
<form method="post">
	<div class="yoBro-settings-panel">
		<h3 class="yoBro-settings-title"><?php esc_html_e('Yo Bro Settings', 'yobro') ?></h3>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Enable Files in Chat', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<select name="files_enable">
					<option value="disable" <?php if(isset($yo_bro_settings['files_enable'])) echo ($yo_bro_settings['files_enable'] == 'disable' ? 'selected="selected"' : '') ?>>Disable</option>
					<option value="enable"  <?php if(isset($yo_bro_settings['files_enable'])) echo ($yo_bro_settings['files_enable'] == 'enable' ? 'selected="selected"' : '') ?>>Enable</option>
				</select>
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('AWS Access Key ID', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="aws_access_key_id" value="<?php echo ( isset( $yo_bro_settings['aws_access_key_id'] ) && !empty( $yo_bro_settings['aws_access_key_id'] ) ) ? $yo_bro_settings['aws_access_key_id'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('AWS Secret Access Key', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="aws_secret_access_key" value="<?php echo ( isset( $yo_bro_settings['aws_secret_access_key'] ) && !empty( $yo_bro_settings['aws_secret_access_key'] ) ) ? $yo_bro_settings['aws_secret_access_key'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('AWS Bucket Name', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="aws_bucket_name" value="<?php echo ( isset( $yo_bro_settings['aws_bucket_name'] ) && !empty( $yo_bro_settings['aws_bucket_name'] ) ) ? $yo_bro_settings['aws_bucket_name'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('AWS Bucket Region', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="aws_bucket_region" value="<?php echo ( isset( $yo_bro_settings['aws_bucket_region'] ) && !empty( $yo_bro_settings['aws_bucket_region'] ) ) ? $yo_bro_settings['aws_bucket_region'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Maximum File Size in MB', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="max_file_size" value="<?php echo ( isset( $yo_bro_settings['max_file_size'] ) && !empty( $yo_bro_settings['max_file_size'] ) ) ? $yo_bro_settings['max_file_size'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Maximum Number of Files in Single Upload', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="max_number_of_files" value="<?php echo ( isset( $yo_bro_settings['max_number_of_files'] ) && !empty( $yo_bro_settings['max_number_of_files'] ) ) ? $yo_bro_settings['max_number_of_files'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Enable Multiple Files', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<select name="multiple_files_enable">
					<option value="disable" <?php if(isset($yo_bro_settings['multiple_files_enable'])) echo ($yo_bro_settings['multiple_files_enable'] == 'disable' ? 'selected="selected"' : '') ?>>Disable</option>
					<option value="enable"  <?php if(isset($yo_bro_settings['multiple_files_enable'])) echo ($yo_bro_settings['multiple_files_enable'] == 'enable' ? 'selected="selected"' : '') ?>>Enable</option>
				</select>
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Enable Avatar', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<select name="yobro_enable_avatar">
					<option value="disable" <?php if(isset($yo_bro_settings['yobro_enable_avatar'])) echo ($yo_bro_settings['yobro_enable_avatar'] == 'disable' ? 'selected="selected"' : '') ?>>Disable</option>
					<option value="enable"  <?php if(isset($yo_bro_settings['yobro_enable_avatar'])) echo ($yo_bro_settings['yobro_enable_avatar'] == 'enable' ? 'selected="selected"' : '') ?>>Enable</option>
				</select>
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Chat Page Url', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="chat_page_url" value="<?php echo ( isset( $yo_bro_settings['chat_page_url'] ) && !empty( $yo_bro_settings['chat_page_url'] ) ) ? $yo_bro_settings['chat_page_url'] : ''; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Number of Conversation in Notification', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="chat_notification_number" value="<?php echo ( isset( $yo_bro_settings['chat_notification_number'] ) && !empty( $yo_bro_settings['chat_notification_number'] ) ) ? $yo_bro_settings['chat_notification_number'] : '5'; ?>">
			</div>
		</div>
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Number of Message in MessageBox', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="number_of_messages" value="<?php echo ( isset( $yo_bro_settings['number_of_messages'] ) && !empty( $yo_bro_settings['number_of_messages'] ) ) ? $yo_bro_settings['number_of_messages'] : '30'; ?>">
			</div>
		</div>
	</div>

	<div class="yoBro-settings-panel">
		<div class="yoBro-input-wrapper">
			<span class="yoBro-input-title"><?php esc_html_e('Chat Button Name', 'yobro') ?></span>
			<div class="yoBro-input-field">
				<input type="text" class="widefat rq-rub-input-field" name="chat_button_name" value="<?php echo ( isset( $yo_bro_settings['chat_button_name'] ) && !empty( $yo_bro_settings['chat_button_name'] ) ) ? $yo_bro_settings['chat_button_name'] : 'Chat'; ?>">
			</div>
		</div>
	</div>
	<?php wp_nonce_field( 'nonce_yo_bro_settings', 'yo_bro_settings' ); ?>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e("Save Changes", 'yobro') ?>"></p>
</form>
