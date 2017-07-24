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

	// directories array
	$excludeDir = $options['directories'];
	echo '<pre>';
	print_r($excludeDir);
	echo '</pre>';

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

			$filepath = $iterator->getPathname();

			// do not scan directories listed in $excludeDir array
			$match = 0; // set recursive OR initial state

			foreach($excludeDir as $dir) {
				$dir_preg_match_pattern = '~'.$dir.'+~';
				if(preg_match($dir_preg_match_pattern, $filepath) === 0) {
					$match = $match || 0;
				} else {
					$match = 1;
				}
				return $match;
			}

			if($match === 0) {
				//  in_array = set to include extensions in $extensions array
				// !in_array = set to exclude extensions in $extensions array ? issue with !in_array @ Linux Ubuntu 13.10
				if(in_array(strtolower($iterator->getExtension()), $extensions)) {
					echo '$dir: ' . $dir . ' - ';
					echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' ----- ';
					echo 'SCAN' . '<br/>';
				}
			} else {
				echo '$dir: ' . $dir . ' - ';
				echo 'getPath:'.$iterator->getPath() . ' | ' . 'getSubPath:'.$iterator->getSubPath() . ' | ' . 'getPathname:'.$iterator->getPathname() . ' | ' . ' ----- ';
				echo 'DO NOT SCAN' . '<br/>';
			}
		}

		// move iterator pointer
		$iterator->next();
	}
}
osc_add_hook('admin_footer', 'afm_test');

?>