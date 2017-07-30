<?php
/*
Plugin Name: Advanced File Monitor
Plugin URI:
Description: Alerts Admins whenever system files modifications are detected
Version: 4.5 mod
Author: JChapman & dev101
Author URI:
Update URI:
Short Name: AFM
*/

// Install
function afm_install () {
	if(version_compare(PHP_VERSION, '5.3.8', '>=')) {

		$base_path = osc_base_path();
		$cron = 'hourly';

		// set options
		osc_set_preference('afm_path', $base_path, 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_cron', $cron, 'advanced-file-monitor', 'STRING');

		// set scan results
		osc_set_preference('afm_files', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_diffs', '', 'advanced-file-monitor', 'STRING');

		// set excluded extensions (global)
		osc_set_preference('afm_extensions', '', 'advanced-file-monitor', 'STRING');

		// set excluded directories
		osc_set_preference('afm_exDir_01', 'oc-content/uploads', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_02', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_03', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_04', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_05', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_06', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_07', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_08', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_09', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_exDir_10', '', 'advanced-file-monitor', 'STRING');

		osc_reset_preferences();

		// run initial scan
		afm_scan();

	} else {
		throw new Exception('Please upgrade your PHP version to 5.3.8 or higher. Your current PHP vesion is: ' . PHP_VERSION . '.');
	}
}

// Uninstall
function afm_uninstall() {
	osc_delete_preference('afm_path', 'advanced-file-monitor');
	osc_delete_preference('afm_cron', 'advanced-file-monitor');
	osc_delete_preference('afm_files', 'advanced-file-monitor');
	osc_delete_preference('afm_diffs', 'advanced-file-monitor');

	osc_delete_preference('afm_extensions', 'advanced-file-monitor');

	osc_delete_preference('afm_exDir_01', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_02', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_03', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_04', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_05', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_06', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_07', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_08', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_09', 'advanced-file-monitor');
	osc_delete_preference('afm_exDir_10', 'advanced-file-monitor');
}

// Get Reference
function afm_get_files() {
	return(unserialize(osc_get_preference('afm_files', 'advanced-file-monitor')));
}

// Get Difference
function afm_get_diffs() {
	return(unserialize(osc_get_preference('afm_diffs', 'advanced-file-monitor')));
}

// Scan Files
function afm_scan($man = 'no', $scanPath = null) {

	// set PHP time limit
	set_time_limit(0);

	// get scan path
	$path = osc_get_preference('afm_path', 'advanced-file-monitor');

	// get excluded directories
	$excludeDir_01 = osc_get_preference('afm_exDir_01', 'advanced-file-monitor');
	$excludeDir_02 = osc_get_preference('afm_exDir_02', 'advanced-file-monitor');
	$excludeDir_03 = osc_get_preference('afm_exDir_03', 'advanced-file-monitor');
	$excludeDir_04 = osc_get_preference('afm_exDir_04', 'advanced-file-monitor');
	$excludeDir_05 = osc_get_preference('afm_exDir_05', 'advanced-file-monitor');
	$excludeDir_06 = osc_get_preference('afm_exDir_06', 'advanced-file-monitor');
	$excludeDir_07 = osc_get_preference('afm_exDir_07', 'advanced-file-monitor');
	$excludeDir_08 = osc_get_preference('afm_exDir_08', 'advanced-file-monitor');
	$excludeDir_09 = osc_get_preference('afm_exDir_09', 'advanced-file-monitor');
	$excludeDir_10 = osc_get_preference('afm_exDir_10', 'advanced-file-monitor');

	// preg_match escape excluded directories
	$dir_preg_match_pattern_01 = '~'.$excludeDir_01.'+~';
	$dir_preg_match_pattern_02 = '~'.$excludeDir_02.'+~';
	$dir_preg_match_pattern_03 = '~'.$excludeDir_03.'+~';
	$dir_preg_match_pattern_04 = '~'.$excludeDir_04.'+~';
	$dir_preg_match_pattern_05 = '~'.$excludeDir_05.'+~';
	$dir_preg_match_pattern_06 = '~'.$excludeDir_06.'+~';
	$dir_preg_match_pattern_07 = '~'.$excludeDir_07.'+~';
	$dir_preg_match_pattern_08 = '~'.$excludeDir_08.'+~';
	$dir_preg_match_pattern_09 = '~'.$excludeDir_09.'+~';
	$dir_preg_match_pattern_10 = '~'.$excludeDir_10.'+~';


	// get excluded extensions
	$extensions = osc_get_preference('afm_extensions', 'advanced-file-monitor');

	// set files array container
	$files = array();

	// iteration class
	$iterator = new RecursiveIteratorIterator
	(
		new RecursiveDirectoryIterator
			(
				$path,
				FilesystemIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD
	);

	// invalid protection
	while($iterator->valid()) {

		// iterator conditions
		if(!$iterator->isDot() && $iterator->isReadable()) {

			// skip directories #1
			if($excludeDir_01 != '' && $excludeDir_02 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #2
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #3
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #4
			elseif($excludeDir_01 != '' && $excludeDir_02 != ''&& $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #5
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #6
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #7
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #8
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 != '' && $excludeDir_09 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #9
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 != '' && $excludeDir_09 != '' && $excludeDir_10 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_09, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #10
			else {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_09, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_10, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

		}

		// move iterator pointer
		$iterator->next();

	}

	// check first time scan
	if(afm_get_files() == '' || empty(afm_get_files())) {
		$dao_preference = new Preference();
		$dao_preference->update(array("s_value" => serialize($files) ), array("s_section" =>"advanced-file-monitor", "s_name" => "afm_files"));
		unset($dao_preference);
		osc_reset_preferences();
	}

	$diffs = '';
	$tmp = '';

	// check for differences in files
	if (!empty($files)) {
		$scannedFiles = afm_get_files();

		if (!empty($scannedFiles)) {

			$diffs = array();
			$tmp = array();

			foreach ($scannedFiles as $key => $value) {

				// deleted files
				if (!array_key_exists($key, $files)) {
					$diffs["del"][$key] = $value;
					$tmp[$key] = $value;
				}

				// modified files
				else {
					if ($files[$key] != $value) {
						$diffs["alt"]['old'][$key] = $value;
						$diffs['alt']['new'][$key] = $files[$key];
						$tmp[$key] = $files[$key];
					}

				// unchanged
					else {
						$tmp[$key] = $value;
					}
				}

			}

			// new files
			if (count($tmp) < count($files)) {
				$diffs["add"] = array_diff_assoc($files, $tmp);
			}

			if(!empty($diffs)) {
				$diffs['files'] = $files;
			}

			unset($tmp);

			// store differences
			$dao_preference = new Preference();
			$dao_preference->update(array("s_value" => serialize($diffs)), array("s_section" =>"advanced-file-monitor", "s_name" => "afm_diffs"));
			unset($dao_preference);
			osc_reset_preferences();

			// send email notification
			if(!empty($diffs)) {
				afm_email();
			}

		}

		if($man === 'yes') {
			return count($diffs);
		}

	}

}

/**
 * Send email notification to admin about changes to the files
 */
function afm_email() {

	// get difference
	$diffs = afm_get_diffs();

	// empty email fail safe
	if(empty($diffs)) {
		// repeat scan procedure to prevent empty email report being sent
		afm_scan();
	// construct email report
	} else {
		
		// set email notification title
		$title = 'Advanced File Monitor' . ' :: ' . 'Changes Detected';

		// set email notification content
		$body  = 'Advanced File Monitor detected changes:';
		$body .= '<br/>';
		$body .= '<br/>';

		################################################################
		# include entire list of changed files into email notification #
		################################################################

		// altered files
		if(!empty($diffs['alt'])) {
			$body .= '<h2>Modified Files</h2>' . PHP_EOL;
			$body .= '<table border="1">' . PHP_EOL;
			$body .= '<thead>' . PHP_EOL;
			$body .= '<tr>' . PHP_EOL;
			$body .= '<th width="100">N</th>' . PHP_EOL;
			$body .= '<th>File</th>' . PHP_EOL;
			$body .= '<th>Key</th>' . PHP_EOL;
			$body .= '<th>SHA1</th>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$body .= '</thead>' . PHP_EOL;

			$body .= '<tbody>' . PHP_EOL;
			$alt_color = ''; // define empty style variable
			foreach($diffs['alt'] as $key => $v) {
				if($key === 'new') {
					$alt_color = 'style="color:#FF0000;"'; // set style for new key rows
				}
				$i = 1;
				foreach($v as $key1 => $v1) {
			$body .= '<tr ' . $alt_color . '>' . PHP_EOL;
			$body .= '<td>' . $i . '</td>' . PHP_EOL;
			$body .= '<td>' . $key1 . '</td>' . PHP_EOL;
			$body .= '<td width="50">' . $key . '</td>' . PHP_EOL;
			$body .= '<td>' . $v1 . '</td>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$i++;
				}
			}
			$body .= '</tbody>' . PHP_EOL;
			$body .= '</table>' . PHP_EOL;
		}

		// new files
		if(!empty($diffs['add'])) {
			$body .= '<h2>New Files</h2>' . PHP_EOL;
			$body .= '<table border="1">' . PHP_EOL;
			$body .= '<thead>' . PHP_EOL;
			$body .= '<tr>' . PHP_EOL;
			$body .= '<th width="100">N</th>' . PHP_EOL;
			$body .= '<th>File</th>' . PHP_EOL;
			$body .= '<th>SHA1</th>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$body .= '</thead>' . PHP_EOL;

			$body .= '<tbody>' . PHP_EOL;
			$i = 1;
			foreach($diffs['add'] as $add => $addV) {
			$body .= '<tr>' . PHP_EOL;
			$body .= '<td>' . $i . '</td>' . PHP_EOL;
			$body .= '<td span style="color:#0000FF;">' . $add . '</td>' . PHP_EOL;
			$body .= '<td>' . $addV . '</td>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$i++;
			}
			$body .= '</tbody>' . PHP_EOL;
			$body .= '</table>' . PHP_EOL;
		}

		// deleted files
		if(!empty($diffs['del'])) {
			$body .= '<h2>Deleted Files</h2>' . PHP_EOL;
			$body .= '<table border="1">' . PHP_EOL;
			$body .= '<thead>' . PHP_EOL;
			$body .= '<tr>' . PHP_EOL;
			$body .= '<th width="100">N</th>' . PHP_EOL;
			$body .= '<th>File</th>' . PHP_EOL;
			$body .= '<th>SHA1</th>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$body .= '</thead>' . PHP_EOL;

			$body .= '<tbody>' . PHP_EOL;
			$i = 1;
			foreach($diffs['del'] as $del => $delV) {
			$body .= '<tr>' . PHP_EOL;
			$body .= '<td>' . $i . '</td>' . PHP_EOL;
			$body .= '<td span style="color:#FF0000;">' . $del . '</td>' . PHP_EOL;
			$body .= '<td>' . $delV . '</td>' . PHP_EOL;
			$body .= '</tr>' . PHP_EOL;
			$i++;
			}
			$body .= '</tbody>' . PHP_EOL;
			$body .= '</table>' . PHP_EOL;
		}

		##########################################################
		# remove exposure of admin URL inside notification email #
		##########################################################

		// $afmLink  = osc_admin_base_url(true) . '?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_view_changes.php';
		// $afm_link = '<a href="' . $afmLink . '" >' . $afmLink . '</a>';
		// $body .= 'Click here to learn more:' . ' ' . $afm_link;
		// $body .= '<br/>';
		// $body .= '<br/>';

		// send email reports to all admins
		$admins = Admin::newInstance()->listAll();

        foreach($admins as $admin) {
            if( !empty($admin['s_email']) && ($admin['b_moderator'] == 0) ) {
				// set email params
				$emailParams   =  array
				(
					'subject'  => $title,
					'to'       => $admin['s_email'],
					'to_name'  => 'Admin',
					'body'     => $body,
					'alt_body' => $body
				);

				// send email
				osc_sendMail($emailParams);
			}
        }
		
	}

}

// Cron Job
function afm_cron_function() {
	afm_scan();
}

// System Path Mismatch Error Flash Message
function afm_system_path_mismatch_flash_message() {

	$base_path_check = osc_get_preference('afm_path', 'advanced-file-monitor');

	if($base_path_check != osc_base_path()) {
		if(osc_version() >= 320 ) {
			osc_add_flash_error_message('<a href="' . osc_route_admin_url('afm-settings') . '">' . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/warning-sign.png" style="vertical-align:middle; padding:0 5px;" />' . __('Advanced File Monitor :: System Path has changed! Please review and update <strong>Base Scan Path</strong> field', 'advanced_file_monitor') . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/new_window.png" style="vertical-align:baseline; padding:0 5px;" />' . '</a>', 'admin');
		} else {
			osc_add_flash_error_message('<a href="' . osc_admin_base_url('true') . '?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_settings.php' . '">' . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/warning-sign.png" vertical-align:middle; padding:0 5px;" />' . __('Advanced File Monitor :: System Path has changed! Please review and update <strong>Base Scan Path</strong> field.', 'advanced_file_monitor') . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/new_window.png" style="vertical-align:baseline; padding:0 5px;" />' . '</a>', 'admin');
		}
	}
}
// check current location
$route = Params::getParamsAsArray();
if(isset($route['route'])) {
	// prevent error flash message @ afm-settings page
	if($route['route'] != 'afm-settings') {
		// insert warning flash message @ route pages
		osc_add_hook('init_admin', 'afm_system_path_mismatch_flash_message');
	}
} else {
	// insert warning flash message @ other admin pages
	osc_add_hook('init_admin', 'afm_system_path_mismatch_flash_message');
}

// Difference Detection Error Flash Message
function afm_difference_detection_flash_message() {

	$diffs = afm_get_diffs();

	if(!empty($diffs) && Params::getParam('afmAction') == '' && osc_is_admin_user_logged_in() ) {
		if(osc_version() >= 320 ) {
			osc_add_flash_error_message('<a href="' . osc_route_admin_url('afm-scan') . '">' . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/warning-sign.png" style="vertical-align:middle; padding:0 5px;" />' . __('Advanced File Monitor :: Changes Detected', 'advanced_file_monitor') . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/new_window.png" style="vertical-align:baseline; padding:0 5px;" />' . '</a>', 'admin');
		} else {
			osc_add_flash_error_message('<a href="' . osc_admin_base_url('true') . '?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_view_changes.php' . '">' . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/warning-sign.png" vertical-align:middle; padding:0 5px;" />' . __('Advanced File Monitor :: Changes Detected', 'advanced_file_monitor') . '<img src="' . osc_base_url() . 'oc-content/plugins/advanced_file_monitor/icons/new_window.png" style="vertical-align:baseline; padding:0 5px;" />' . '</a>', 'admin');
		}
	}
}
// check current location
$route = Params::getParamsAsArray();
if(isset($route['route'])) {
	// prevent error flash message @ afm-scan page
	if($route['route'] != 'afm-scan') {
		// insert warning flash message @ route pages
		osc_add_hook('init_admin', 'afm_difference_detection_flash_message');
	}
} else {
	// insert warning flash message @ other admin pages
	osc_add_hook('init_admin', 'afm_difference_detection_flash_message');
}

// Admin Menu
function afm_admin_menu() {
	if(osc_version() >= 320 ) {
		osc_admin_menu_tools(__('Advanced File Monitor', 'advanced_file_monitor'), osc_route_admin_url('afm-settings'), 'afm_admin_settings');
	} else {
		osc_admin_menu_tools(__('Advanced File Monitor', 'advanced_file_monitor'), osc_admin_render_plugin_url('advanced_file_monitor/admin/admin_settings.php'), 'afm_admin_settings');
	}

	osc_enqueue_style('advfilemon', osc_base_url() . 'oc-content/plugins/advanced_file_monitor/css/advfilemon.css');
}

// Config
function advanced_ad_management_config() {
	osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/admin/admin_settings.php') ;
}

#######################################
# Debug AMF | uncomment hook to debug #
#######################################
function afm_debug() {

	//$diffs = afm_get_diffs();
	//echo '<pre>';
	//print_r($diffs);
	//echo '<pre>';

	// set PHP time limit
	set_time_limit(0);

	// get scan path
	$path = osc_get_preference('afm_path', 'advanced-file-monitor');

	// get excluded directories
	$excludeDir_01 = osc_get_preference('afm_exDir_01', 'advanced-file-monitor');
	$excludeDir_02 = osc_get_preference('afm_exDir_02', 'advanced-file-monitor');
	$excludeDir_03 = osc_get_preference('afm_exDir_03', 'advanced-file-monitor');
	$excludeDir_04 = osc_get_preference('afm_exDir_04', 'advanced-file-monitor');
	$excludeDir_05 = osc_get_preference('afm_exDir_05', 'advanced-file-monitor');
	$excludeDir_06 = osc_get_preference('afm_exDir_06', 'advanced-file-monitor');
	$excludeDir_07 = osc_get_preference('afm_exDir_07', 'advanced-file-monitor');
	$excludeDir_08 = osc_get_preference('afm_exDir_08', 'advanced-file-monitor');
	$excludeDir_09 = osc_get_preference('afm_exDir_09', 'advanced-file-monitor');
	$excludeDir_10 = osc_get_preference('afm_exDir_10', 'advanced-file-monitor');

	// preg_match escape excluded directories
	$dir_preg_match_pattern_01 = '~'.$excludeDir_01.'+~';
	$dir_preg_match_pattern_02 = '~'.$excludeDir_02.'+~';
	$dir_preg_match_pattern_03 = '~'.$excludeDir_03.'+~';
	$dir_preg_match_pattern_04 = '~'.$excludeDir_04.'+~';
	$dir_preg_match_pattern_05 = '~'.$excludeDir_05.'+~';
	$dir_preg_match_pattern_06 = '~'.$excludeDir_06.'+~';
	$dir_preg_match_pattern_07 = '~'.$excludeDir_07.'+~';
	$dir_preg_match_pattern_08 = '~'.$excludeDir_08.'+~';
	$dir_preg_match_pattern_09 = '~'.$excludeDir_09.'+~';
	$dir_preg_match_pattern_10 = '~'.$excludeDir_10.'+~';

	// get excluded extensions
	$extensions = osc_get_preference('afm_extensions', 'advanced-file-monitor');

	// set array container
	$files = array();

	// iteration class
	$iterator = new RecursiveIteratorIterator
	(
		new RecursiveDirectoryIterator
			(
				$path,
				FilesystemIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::LEAVES_ONLY,
			RecursiveIteratorIterator::CATCH_GET_CHILD
	);

	// invalid protection
	while($iterator->valid()) {

		// iterator conditions
		if(!$iterator->isDot() && !$iterator->isDir() && $iterator->isReadable()) {

			// skip directories #1
			if($excludeDir_01 != '' && $excludeDir_02 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #2
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #3
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #4
			elseif($excludeDir_01 != '' && $excludeDir_02 != ''&& $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #5
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #6
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #7
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #8
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 != '' && $excludeDir_09 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #9
			elseif($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '' && $excludeDir_06 != '' && $excludeDir_07 != '' && $excludeDir_08 != '' && $excludeDir_09 != '' && $excludeDir_10 == '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_09, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

			// skip directories #10
			else {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_06, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_07, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_08, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_09, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_10, $iterator->getPathname()) === 0 ) {
					if(stripos($extensions, strtolower($iterator->getExtension())) === FALSE) {
						// storage layer
						$key = str_replace('\\', '/', $iterator->key()); // unify path structure in Windows and Linux
						$files[$key] = @hash_file('sha1', $key); // suppress PHP Warning in Windows: hash_file(): failed to open stream: Permission denied
					}
				}
			}

		}

		// move iterator pointer
		$iterator->next();

	}

	$diffs = '';
	$tmp = '';

	// check for differences in files
	if (!empty($files)) {
		$scannedFiles = afm_get_files();

		//echo '$scannedFiles Array';
		//echo '<pre>';
		//print_r($scannedFiles);
		//echo '<pre>';

		$diffs = array();
		$tmp = array();

		foreach ($scannedFiles as $key => $value) {

			// deleted files
			if (!array_key_exists($key, $files)) {
				$diffs["del"][$key] = $value;
				$tmp[$key] = $value;

				echo 'deleted files - ' . '$diffs["del"][$key]: ' . $diffs["del"][$key] . '<br/>';
				echo 'deleted files - ' . '$tmp[$key]: ' . $tmp[$key] . '<br/>';
			}

			// modified files
			else {
				if ($files[$key] != $value) {
					$diffs["alt"]['old'] = array($key => $value);
					$diffs['alt']['new'] = array($key => $files[$key]);
					$tmp[$key] = $files[$key];

					echo 'modified files - ' . '$diffs["alt"]["old"]: ';
					print_r($diffs["alt"]['old']);
					echo '<br/>';

					echo 'modified files - ' . '$diffs["alt"]["new"]: ';
					print_r($diffs['alt']['new']);
					echo '<br/>';
					echo 'modified files - ' . '$tmp[$key]: ' . $tmp[$key] . '<br/>';
				}

			// unchanged
				else {
					$tmp[$key] = $value;
					//echo 'unchanged - ' . '$tmp[$key]: ' . $tmp[$key] . '<br/>';
				}
			}
		}
	}
}
######################
# uncomment to debug #
######################
//osc_add_hook('admin_footer', 'afm_debug', 10);

/** ROUTES **/

if(osc_version() >= 320 ) {
	osc_add_route('afm-settings', 'afm-settings/', 'afm-settings/', osc_plugin_folder(__FILE__).'admin/admin_settings.php');
	osc_add_route('afm-scan', 'afm-scan/', 'afm-scan/', osc_plugin_folder(__FILE__).'admin/admin_view_changes.php');
}

/** HOOKS **/

// Activate Plugin
osc_register_plugin(osc_plugin_path(__FILE__), 'afm_install');

// Uninstall Plugin
osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'afm_uninstall');

// Configure Link
osc_add_hook(__FILE__ . '_configure', 'advanced_ad_management_config');

// Admin Menu
if(osc_version() >= 300) {
	osc_add_hook('init_admin', 'afm_admin_menu');
}

// Cron Hook
$cron = osc_get_preference('afm_cron', 'advanced-file-monitor');
if($cron != 'MANUAL') {
	osc_add_hook('cron_' . $cron, 'afm_cron_function');
}

?>
