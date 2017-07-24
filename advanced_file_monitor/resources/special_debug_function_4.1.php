<?php

#################################
### SPECIAL DEBUGGER FUNCTION ###
#################################

function afm_test() {

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
}
osc_add_hook('admin_footer', 'afm_test');

?>