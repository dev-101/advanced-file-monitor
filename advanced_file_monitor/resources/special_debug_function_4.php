<?php

#################################
### SPECIAL DEBUGGER FUNCTION ###
#################################

function afm_test($man = 'no', $scanPath = null) {

	// set PHP time limit
	set_time_limit(0);

	// get scan options
	$options = afm_get_options();

	// set scan path
	$path = ($scanPath != null) ? $scanPath : $options['path'];

	// set array container
	$files = array();

	// get excluded directories
	$excludeDir_01 = osc_get_preference('afm_exDir_01', 'advanced-file-monitor');
	$excludeDir_02 = osc_get_preference('afm_exDir_02', 'advanced-file-monitor');
	$excludeDir_03 = osc_get_preference('afm_exDir_03', 'advanced-file-monitor');
	$excludeDir_04 = osc_get_preference('afm_exDir_04', 'advanced-file-monitor');
	$excludeDir_05 = osc_get_preference('afm_exDir_05', 'advanced-file-monitor');

	// preg_match escape excluded directories
	$dir_preg_match_pattern_01 = '~'.$excludeDir_01.'+~';
	$dir_preg_match_pattern_02 = '~'.$excludeDir_02.'+~';
	$dir_preg_match_pattern_03 = '~'.$excludeDir_03.'+~';
	$dir_preg_match_pattern_04 = '~'.$excludeDir_04.'+~';
	$dir_preg_match_pattern_05 = '~'.$excludeDir_05.'+~';

	// extensions array
	$extensions = $options['extensions'];

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
			if($excludeDir_01 != '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0 ) {
					//  in_array = set to include extensions in $extensions array
					// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
					if(in_array(strtolower($iterator->getExtension()), $extensions)) {
						echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
						echo 'SCAN' . '<br/>';
					}
				} else {
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
					echo 'DO NOT SCAN' . '<br/>';
				}
			}

			// skip directories #2
			if($excludeDir_01 != '' && $excludeDir_02 != '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0 ) {
					//  in_array = set to include extensions in $extensions array
					// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
					if(in_array(strtolower($iterator->getExtension()), $extensions)) {
						echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
						echo 'SCAN' . '<br/>';
					}
				} else {
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
					echo 'DO NOT SCAN' . '<br/>';
				}
			}

			// skip directories #3
			if($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0 ) {
					//  in_array = set to include extensions in $extensions array
					// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
					if(in_array(strtolower($iterator->getExtension()), $extensions)) {
						echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
						echo 'SCAN' . '<br/>';
					}
				} else {
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
					echo 'DO NOT SCAN' . '<br/>';
				}
			}

			// skip directories #4
			if($excludeDir_01 != '' && $excludeDir_02 != ''&& $excludeDir_03 != '' && $excludeDir_04 != '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0 ) {
					//  in_array = set to include extensions in $extensions array
					// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
					if(in_array(strtolower($iterator->getExtension()), $extensions)) {
						echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
						echo 'SCAN' . '<br/>';
					}
				} else {
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
					echo 'DO NOT SCAN' . '<br/>';
				}
			}

			// skip directories #5
			if($excludeDir_01 != '' && $excludeDir_02 != '' && $excludeDir_03 != '' && $excludeDir_04 != '' && $excludeDir_05 != '') {
				if(	preg_match($dir_preg_match_pattern_01, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_02, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_03, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_04, $iterator->getPathname()) === 0
				&&	preg_match($dir_preg_match_pattern_05, $iterator->getPathname()) === 0 ) {
					//  in_array = set to include extensions in $extensions array
					// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
					if(in_array(strtolower($iterator->getExtension()), $extensions)) {
						echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
						echo 'SCAN' . '<br/>';
					}
				} else {
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
					echo 'DO NOT SCAN' . '<br/>';
				}
			}

		}

		// move iterator pointer
		$iterator->next();
	}
}
osc_add_hook('admin_footer', 'afm_test');

?>