<?php
global $wpdb, $wp_version;
?>

<style>
.adminContainer{
  display: flex;
  justify-content: center;
  align-items: center;
  align-content: center;
  margin-top: 100px;
}
</style>

<div class="adminContainer">
  <h1>Welcome to Yobro</h1>
</div>

<div class="yobro-trick yobro-wrap">
	<table class="widefat yobro-system-status" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="System Status"><h4 style="margin-top: 0">System Status</h4></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>WP Version: </td>
				<td class="<?php echo $wp_version >= YOBRO_REQUIRED_WP_VERSION ? 'yobro-status-success' : 'yobro-status-error' ?>"><?php echo $wp_version;?>
					<?php if($wp_version < YOBRO_REQUIRED_WP_VERSION){ ?>
					<code><?php esc_html_e( 'The Recommened Minimum WP version is '.YOBRO_REQUIRED_WP_VERSION, 'yobro' ); ?></code>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>WP Memory Limit: </td>
				<td class="<?php echo esc_attr(WP_MEMORY_LIMIT) >= 256 ? 'yobro-status-success' : 'yobro-status-error' ?>"><?php echo esc_attr(WP_MEMORY_LIMIT); ?>
					<code><?php esc_html_e( 'The Recommened Minimum WP Memory Limit is 256M', 'yobro' ); ?></code>
				</td>
			</tr>
			<tr>
			<td>WP Multisite: </td>
				<td><?php if(is_multisite()) echo 'Yes'; else echo 'No' ?> </td>
			</tr>
			<tr class="real-memory"><td>Server Memory Limit:</td>
				<td class="<?php echo ini_get('memory_limit') >= 256 ? 'yobro-status-success' : 'yobro-status-error' ?>"> <?php echo ini_get('memory_limit') ?>
					<?php if(ini_get('memory_limit') < 256){ ?>
						<code><?php esc_html_e( 'The Recommened Minimum Server Memory Limit is 256M', 'yobro' ); ?></code>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>PHP Version: </td>
				<td class="<?php echo phpversion() >= YOBRO_REQUIRED_PHP_VERSION ? 'yobro-status-success' : 'yobro-status-error' ?>"><?php echo esc_attr(phpversion()); ?>
					<?php if(phpversion() < YOBRO_REQUIRED_PHP_VERSION){ ?>
						<code><?php esc_html_e( 'The Recommened Minimum PHP version is '.YOBRO_REQUIRED_PHP_VERSION, 'yobro' ); ?></code>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>PHP Post Maximum Size: </td>
				<td><?php echo esc_attr(ini_get( 'post_max_size' )); ?> </td>
			</tr>
			<tr>
				<td>PHP Maximum Execution Time: </td>
				<td><?php echo esc_attr(ini_get( 'max_execution_time' )); ?> </td>
			</tr>
			<tr>
				<td>PHP Maximum Input Vars: </td>
				<td class="<?php echo ini_get('max_input_vars') >= 3000 ? 'yobro-status-success' : 'yobro-status-error' ?>"><?php echo esc_attr(ini_get('max_input_vars')); ?>
					<?php if(ini_get('max_input_vars') < 3000) { ?>
						<code><?php esc_html_e( 'The Recommened Minimum Input Vars is 3000', 'yobro' ); ?></code>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Maximum Upload Size: </td>
				<td><?php echo esc_attr(size_format(wp_max_upload_size())); ?> </td>
			</tr>
			<tr>
				<td>Mysql Version: </td>
				<td class="<?php echo $wpdb->db_version() >= 5.6 ? 'yobro-status-success' : 'yobro-status-error' ?>"><?php echo esc_attr($wpdb->db_version()); ?>
						<?php if($wpdb->db_version() < 5.6){ ?>
							<code><?php esc_html_e( 'The Recommened Minimum Mysql version is 5.6.0 or greater', 'yobro' ); ?></code>
						<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<?php
	$query = $wpdb->prepare("SELECT log_details, created_at FROM {$wpdb->prefix}yobro_logs WHERE id <> %s ORDER BY id DESC LIMIT 20", '');
	$results = $wpdb->get_results($query, 'ARRAY_A');
	$new_result = [];
	foreach ($results as $key => $error) {
		$new_result[$error['created_at']] = $error['log_details'];
	}
?>

<div class="adminContainer">
  <h1> Recent Error Logs </h1>
</div>
<div class="yobro-trick yobro-wrap">
	<pre class="scwp-snippet">
		<div class="scwp-clippy-icon" data-clipboard-snippet="">
			<img class="clippy" width="13" src="<?php print YOBRO_IMG ?>clippy.svg" alt="Copy to clipboard">
		</div>
		<code class="js hljs php"><?php return esc_attr(print_r($new_result)) ?></code>
	</pre>
</div>
