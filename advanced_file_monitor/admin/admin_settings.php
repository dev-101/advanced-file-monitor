<?php if ( ( !defined('OC_ADMIN') || OC_ADMIN!==true ) ) exit('Access is not allowed.');

	// Manual Scan / View Results routing
	$ManualScan = Params::getParam('manualscan');

	if ($ManualScan === 'yes') {
		// show flash message & auto-redirect
		if (afm_scan('yes') > 0) {
			if (osc_version() >= 320 ) {
				// auto-redirect
				header('Location: ' . osc_route_admin_url('afm-scan'));
			} else {
				// auto-redirect
				header('Location: ' . osc_admin_base_url('true') . '?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_view_changes.php');
			}
		} else {
			// show flash message
			osc_add_flash_ok_message(__('Manual Scan completed. No changes detected.','advanced_file_monitor'), 'admin');
			// redirect
			if (osc_version() >= 320 ) {
				header('Location: ' . osc_route_admin_url('afm-settings'));
			} else {
				header('Location: ' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=afm-settings');
			}
		}
	}

	// Save Form Data
	if ( Params::getParam('option') == 'advanced_file_monitor_admin_settings' ) {

		// Base Scan Bath
		if (Params::getParam('path') != '') {
			$path = Params::getParam('path');
			osc_set_preference('afm_path', $path, 'advanced-file-monitor', 'STRING');
		} else {
			$path = osc_base_path();
			osc_set_preference('afm_path', $path, 'advanced-file-monitor', 'STRING');
		}

		// Cron Job
		if (Params::getParam('cron') != '') {
			$cron = Params::getParam('cron');
			osc_set_preference('afm_cron', $cron, 'advanced-file-monitor', 'STRING');
		}

		// Extensions
		if (Params::getParam('extensions') != '') {
			$extensions = Params::getParam('extensions');
			$extensions = strtolower($extensions); // convert to lowercase
			$extensions = str_replace(' ', '', $extensions); // remove white space
			$extensions = rtrim($extensions, ','); // remove last comma
			osc_set_preference('afm_extensions', $extensions, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_extensions', '', 'advanced-file-monitor', 'STRING');
		}

		// Directories
		if (Params::getParam('afm_directories') != '') {
			$afm_directories = Params::getParam('afm_directories');
			// trim
			$afm_directories = trim($afm_directories); // trim space
			// unify path structure in Windows and Linux
			$afm_directories = str_replace('\\', '/', $afm_directories); // unify slash on Linux and Windows
			// replace comma with new line
			$afm_directories = str_replace(',', PHP_EOL, $afm_directories);
			// string into array
			$afm_directories = explode(PHP_EOL, trim($afm_directories));
			// trim array elements
			$afm_directories = array_map('trim', $afm_directories);
			// remove empty/NULL array elements
			$afm_directories = array_filter($afm_directories);
			// array into string
			$afm_directories = implode($afm_directories, PHP_EOL);

			osc_set_preference('afm_directories', $afm_directories, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_directories', '', 'advanced-file-monitor', 'STRING');
		}

		osc_add_flash_ok_message(__('Settings Saved', 'advanced_file_monitor'), 'admin');
		// redirect
		if (osc_version() >= 320 ) {
			header('Location: ' . osc_route_admin_url('afm-settings'));
		} else {
			header('Location: ' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=afm-settings');
		}
		osc_reset_preferences();

	}

?>

<h2><?php echo __('Advanced File Monitor Settings' , 'advanced_file_monitor'); ?></h2>
<form action="<?php osc_admin_base_url(true); ?>" method="post">
	<input type="hidden" name="page" value="plugins" />
	<input type="hidden" name="action" value="renderplugin" />
<?php if(osc_version() >= 320 ) { ?>
	<input type="hidden" name="route" value="afm-settings" />
<?php } else { ?>
	<input type="hidden" name="file" value="advanced_file_monitor/admin/admin_settings.php" />
<?php } ?>
	<input type="hidden" name="option" value="advanced_file_monitor_admin_settings" />
	<div>
	<fieldset>

		<hr style="border-style:ridge;" />

	<div style="display:block; float:right; clear:both;">
		<!-- Manual Scan -->
		<?php if (osc_version() >= 320 ) { ?>
			<a id="manual-scan" class="btn btn-submit" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&route=afm-settings&manualscan=yes"><?php _e('MANUAL SCAN','advanced_file_monitor'); ?></a>
		<?php } else { ?>
			<a id="manual-scan" class="btn btn-submit" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_settings.php&manualscan=yes"><?php _e('MANUAL SCAN','advanced_file_monitor'); ?></a>
		<?php } ?>

		<script>
		// prevent double mouse click
		$(document).ready(function() {
			$("#manual-scan").dblclick(function(e) {
				e.preventDefault();
			});
		});
		</script>

		<!-- Manual Scan Results -->
		<?php if(osc_version() >= 320 ) { ?>
			<a class="btn btn-submit" style="background-color:#FF7500;" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&route=afm-scan"><?php _e('VIEW RESULTS','advanced_file_monitor'); ?></a>
		<?php } else { ?>
			<a class="btn btn-submit" style="background-color:#FF7500;" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_settings.php"><?php _e('VIEW RESULTS','advanced_file_monitor'); ?></a>
		<?php } ?>
	</div>
		<br/>
		<div class="clear"></div>

		<hr style="border-style:ridge;" /><br/>

		<!-- Base Scan Path -->
		<label for="path" style="font-weight:700; background-color:#EEE; padding:8px 1%; width:98%; display:inline-block; border:1px solid #CCC; border-bottom: 3px solid #333;"><?php _e('Base Scan Path', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<span style="font-size:small;color:gray;"><?php echo __('System Path' , 'advanced_file_monitor'); ?>: <strong><?php echo osc_base_path(); ?></strong></span>
		<br/>
		<input type="text" name="path" id="path" placeholder="<?php echo osc_base_path(); ?>" value="<?php echo osc_get_preference('afm_path', 'advanced-file-monitor'); ?>" style="margin:3px 0; padding:8px 1%; width:98%; box-shadow:inset 0 1px 1px #F60; -moz-box-shadow:inset 0 1px 1px #F60; -webkit-box-shadow:inset 0 1px 1px #F60;" />
		<br/><br/><hr style="border-style:ridge;" /><br/>

		<!-- Exclude Files/Directories -->
		<label for="directories" style="font-weight:700; background-color:#EEE; padding:8px 1%; width:98%; display:inline-block; border:1px solid #CCC; border-bottom: 3px solid #333;"><?php _e('Exclude Files/Directories', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<span style="font-size:small;color:gray;">
		<?php echo __('Example 1' , 'advanced_file_monitor'); ?>: <strong>sitemap.xml</strong>
		<br/>
		<?php echo __('Example 2' , 'advanced_file_monitor'); ?>: <strong>my-root-directory</strong>
		<br/>
		<?php echo __('Example 3' , 'advanced_file_monitor'); ?>: <strong>oc-content/example</strong>
		<br/>
		<?php echo __('Example 4' , 'advanced_file_monitor'); ?>: <strong>oc-content/uploads</strong> (default)
		<br/><br/>
		<strong>IMPORTANT</strong>
		<br/>
		Insert <strong>relative</strong> directory or file paths ONE PER LINE
		</span>
		<br/><br/>

		<textarea rows="10" name="afm_directories" id="afm_directories" placeholder="" style="margin:3px 0; padding:8px 1%; width:98%; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;"><?php echo osc_get_preference('afm_directories', 'advanced-file-monitor'); ?></textarea><br/>
		<br/><hr style="border-style:ridge;" /><br/>

		<!-- Extensions -->
		<label for="extensions" style="font-weight:700; background-color:#EEE; padding:8px 1%; width:98%; display:inline-block; border:1px solid #CCC; border-bottom: 3px solid #333;"><?php _e('Exclude File Extensions (Global)', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<div style="display:inline-block; clear:both; float:left; margin-bottom:15px; font-size:small; color:gray; width:100%; max-width:500px;">
			<?php echo __('Example' , 'advanced_file_monitor'); ?>: <strong><?php echo 'xml,txt,ico,jpg,bmp,gif,zip,sql'; ?></strong> (comma separated values)
		</div>
		<br/><br/>
		<input type="text" name="extensions" id="extensions" value="<?php echo osc_get_preference('afm_extensions', 'advanced-file-monitor'); ?>" style="display:block; clear:both; margin:3px 0; padding:8px 1%; width:98%; box-shadow:inset 0 1px 1px #16C562; -moz-box-shadow:inset 0 1px 1px #16C562; -webkit-box-shadow:inset 0 1px 1px #16C562;" />
		<br/><hr style="border-style:ridge;" /><br/>

		<!-- Cron Job -->
		<label for="cron" style="font-weight:700; background-color:#EEE; padding:8px 1%; width:98%; display:inline-block; border:1px solid #CCC; border-bottom: 3px solid #333;"><?php _e('Scan Cron', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<select name="cron" id="cron" />
			<?php $cron = osc_get_preference('afm_cron', 'advanced-file-monitor'); ?>
			<option value="hourly" <?php if($cron == 'hourly') {echo 'selected';} ?> ><?php _e('Hourly','advanced_file_monitor'); ?></option>
			<option value="daily" <?php if($cron == 'daily') {echo 'selected';} ?> ><?php _e('Daily','advanced_file_monitor'); ?></option>
			<option value="weekly" <?php if($cron == 'weekly') {echo 'selected';} ?> ><?php _e('Weekly','advanced_file_monitor'); ?></option>
			<option value="MANUAL" <?php if($cron == 'MANUAL') {echo 'selected';} ?> ><?php _e('Manual','advanced_file_monitor'); ?></option>
		</select>
		<br/><br/><hr style="border-style:ridge;" /><br/>

		<!-- Submit Form -->
		<input class="btn btn-submit" type="submit" value="<?php _e('Save Settings', 'advanced_file_monitor'); ?>" />
		<br/><br/>

	</fieldset>
	</div>
</form>
