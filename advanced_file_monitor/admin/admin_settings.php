<?php if ( ( !defined('OC_ADMIN') || OC_ADMIN!==true ) ) exit('Access is not allowed.');

	// Manual Scan / View Results routing
	$ManualScan = Params::getParam('manualscan');

	if($ManualScan === 'yes') {
		// show flash message & auto-redirect
		if(afm_scan('yes') > 0) {
			if(osc_version() >= 320 ) {
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
			if(osc_version() >= 320 ) {
				header('Location: ' . osc_route_admin_url('afm-settings'));
			} else {
				header('Location: ' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=afm-settings');
			}
		}
	}

	// Save Form Data
	if( Params::getParam('option') == 'advanced_file_monitor_admin_settings' ) {

		// Base Scan Bath
		if(Params::getParam('path') != '') {
			$path = Params::getParam('path');
			osc_set_preference('afm_path', $path, 'advanced-file-monitor', 'STRING');
		} else {
			$path = osc_base_path();
			osc_set_preference('afm_path', $path, 'advanced-file-monitor', 'STRING');
		}

		// Cron Job
		if(Params::getParam('cron') != '') {
			$cron = Params::getParam('cron');
			osc_set_preference('afm_cron', $cron, 'advanced-file-monitor', 'STRING');
		}

		// Extensions
		if(Params::getParam('extensions') != '') {
			$extensions = Params::getParam('extensions');
			$extensions = strtolower($extensions); // convert to lowercase
			$extensions = str_replace(' ', '', $extensions); // remove white space
			$extensions = rtrim($extensions, ','); // remove last comma
			osc_set_preference('afm_extensions', $extensions, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_extensions', '', 'advanced-file-monitor', 'STRING');
		}

		// Directories
		if(Params::getParam('exDir_01') != '') {
			$exDir_01 = Params::getParam('exDir_01');
			$exDir_01 = trim($exDir_01); // trim space
			$exDir_01 = str_replace('\\', '/', $exDir_01); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_01', $exDir_01, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_01', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_02') != '') {
			$exDir_02 = Params::getParam('exDir_02');
			$exDir_02 = trim($exDir_02); // trim space
			$exDir_02 = str_replace('\\', '/', $exDir_02); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_02', $exDir_02, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_02', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_03') != '') {
			$exDir_03 = Params::getParam('exDir_03');
			$exDir_03 = trim($exDir_03); // trim space
			$exDir_03 = str_replace('\\', '/', $exDir_03); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_03', $exDir_03, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_03', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_04') != '') {
			$exDir_04 = Params::getParam('exDir_04');
			$exDir_04 = trim($exDir_04); // trim space
			$exDir_04 = str_replace('\\', '/', $exDir_04); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_04', $exDir_04, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_04', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_05') != '') {
			$exDir_05 = Params::getParam('exDir_05');
			$exDir_05 = trim($exDir_05); // trim space
			$exDir_05 = str_replace('\\', '/', $exDir_05); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_05', $exDir_05, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_05', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_06') != '') {
			$exDir_06 = Params::getParam('exDir_06');
			$exDir_06 = trim($exDir_06); // trim space
			$exDir_06 = str_replace('\\', '/', $exDir_06); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_06', $exDir_06, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_06', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_07') != '') {
			$exDir_07 = Params::getParam('exDir_07');
			$exDir_07 = trim($exDir_07); // trim space
			$exDir_07 = str_replace('\\', '/', $exDir_07); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_07', $exDir_07, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_07', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_08') != '') {
			$exDir_08 = Params::getParam('exDir_08');
			$exDir_08 = trim($exDir_08); // trim space
			$exDir_08 = str_replace('\\', '/', $exDir_08); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_08', $exDir_08, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_08', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_09') != '') {
			$exDir_09 = Params::getParam('exDir_09');
			$exDir_09 = trim($exDir_09); // trim space
			$exDir_09 = str_replace('\\', '/', $exDir_09); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_09', $exDir_09, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_09', '', 'advanced-file-monitor', 'STRING');
		}
		if(Params::getParam('exDir_10') != '') {
			$exDir_10 = Params::getParam('exDir_10');
			$exDir_10 = trim($exDir_10); // trim space
			$exDir_10 = str_replace('\\', '/', $exDir_10); // unify slash on Linux and Windows
			osc_set_preference('afm_exDir_10', $exDir_10, 'advanced-file-monitor', 'STRING');
		} else {
			osc_set_preference('afm_exDir_10', '', 'advanced-file-monitor', 'STRING');
		}

		osc_add_flash_ok_message(__('Settings Saved', 'advanced_file_monitor'), 'admin');
		// redirect
		if(osc_version() >= 320 ) {
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
		<?php if(osc_version() >= 320 ) { ?>
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
			<a class="btn btn-submit" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&route=afm-scan"><?php _e('VIEW RESULTS','advanced_file_monitor'); ?></a>
		<?php } else { ?>
			<a class="btn btn-submit" href="<?php osc_admin_base_url(true); ?>?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_settings.php"><?php _e('VIEW RESULTS','advanced_file_monitor'); ?></a>
		<?php } ?>
	</div>
		<br/>
		<div class="clear"></div>

		<hr style="border-style:ridge;" /><br/>

		<!-- Base Scan Path -->
		<label for="path" style="font-weight:700; background-color:#EEE; padding:5px; width:50%; display:inline-block; max-width:500px; border:1px solid #CCC;"><?php _e('Base Scan Path', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<span style="font-size:small;color:gray;"><?php echo __('System Path:' , 'advanced_file_monitor') , ' ' , osc_base_path(); ?></span>
		<br/>
		<input type="text" name="path" id="path" placeholder="<?php echo osc_base_path(); ?>" value="<?php echo osc_get_preference('afm_path', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #F60; -moz-box-shadow:inset 0 1px 1px #F60; -webkit-box-shadow:inset 0 1px 1px #F60;" />
		<br/><br/><hr style="border-style:ridge;" /><br/>

		<!-- Directories -->
		<label for="directories" style="font-weight:700; background-color:#EEE; padding:5px; width:50%; display:inline-block; max-width:500px; border:1px solid #CCC;"><?php _e('Exclude Directories', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<span style="font-size:small;color:gray;">
		<?php echo __('Example' , 'advanced_file_monitor'); ?>: <strong>oc-content/uploads</strong>
		<br/><br/>
		<strong>IMPORTANT</strong>
		<br/>
		Fill-in input fields in ordered fashion and insert <strong>relative</strong> directory paths
		<br/>
		Do not enter multiple values separated with comma or leave blank fields in between
		</span>
		<br/><br/>

		<input type="text" name="exDir_01" id="exDir_01" placeholder="01." value="<?php echo osc_get_preference('afm_exDir_01', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_02" id="exDir_02" placeholder="02." value="<?php echo osc_get_preference('afm_exDir_02', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_03" id="exDir_03" placeholder="03." value="<?php echo osc_get_preference('afm_exDir_03', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_04" id="exDir_04" placeholder="04." value="<?php echo osc_get_preference('afm_exDir_04', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_05" id="exDir_05" placeholder="05." value="<?php echo osc_get_preference('afm_exDir_05', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_06" id="exDir_06" placeholder="06." value="<?php echo osc_get_preference('afm_exDir_06', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_07" id="exDir_07" placeholder="07." value="<?php echo osc_get_preference('afm_exDir_07', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_08" id="exDir_08" placeholder="08." value="<?php echo osc_get_preference('afm_exDir_08', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_09" id="exDir_09" placeholder="09." value="<?php echo osc_get_preference('afm_exDir_09', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>
		<input type="text" name="exDir_10" id="exDir_10" placeholder="10." value="<?php echo osc_get_preference('afm_exDir_10', 'advanced-file-monitor'); ?>" style="width:100%; max-width:500px; box-shadow:inset 0 1px 1px #008BFF; -moz-box-shadow:inset 0 1px 1px #008BFF; -webkit-box-shadow:inset 0 1px 1px #008BFF;" /><br/>

		<br/><hr style="border-style:ridge;" /><br/>

		<!-- Extensions -->
		<label for="extensions" style="font-weight:700; background-color:#EEE; padding:5px; width:50%; display:inline-block; max-width:500px; border:1px solid #CCC;"><?php _e('Exclude File Extensions', 'advanced_file_monitor'); ?></label>
		<br/><br/>
		<div style="display:inline-block; clear:both; float:left; margin-bottom:15px; font-size:small; color:gray; width:100%; max-width:500px;">
			<?php echo __('Example' , 'advanced_file_monitor'); ?>: <strong><?php echo 'xml,txt,ico,jpg,bmp,gif,zip,sql'; ?></strong> (comma separated values)
		</div>
		<br/><br/>
		<input type="text" name="extensions" id="extensions" value="<?php echo osc_get_preference('afm_extensions', 'advanced-file-monitor'); ?>" style="display:block; clear:both; width:100%; max-width:500px; box-shadow:inset 0 1px 1px #16C562; -moz-box-shadow:inset 0 1px 1px #16C562; -webkit-box-shadow:inset 0 1px 1px #16C562;" />
		<br/><hr style="border-style:ridge;" /><br/>

		<!-- Cron Job -->
		<label for="cron" style="font-weight:700; background-color:#EEE; padding:5px; width:50%; display:inline-block; max-width:500px; border:1px solid #CCC;"><?php _e('Scan Cron', 'advanced_file_monitor'); ?></label>
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