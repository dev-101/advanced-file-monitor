// VERSION 1: NATURAL SORT (FIRST ALL OLD - THEN ALL NEW KEY-VALUES) [FULLY WORKING]

<?php // Modified Files ?>
<?php if(!empty($diffs['alt'])) { ?>

	<h2><?php _e('Modified Files', 'advanced_file_monitor'); ?></h2>
	<table class="table">

		<thead>
			<tr>
				<th><?php _e('N', 'advanced_file_monitor'); ?></th>
				<th><?php _e('File', 'advanced_file_monitor'); ?></th>
				<th><?php _e('Key', 'advanced_file_monitor'); ?></th>
				<th><?php _e('SHA1', 'advanced_file_monitor'); ?></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach($diffs['alt'] as $key => $v) { ?>
			<?php $i = 1; ?>
			<?php foreach($v as $key1 => $v1) { ?>
				<tr <?php if($key == 'new') { echo 'style="color:#F00;"'; } // set red color for new key row ?>>
					<td><?php echo $i; ?></td>
					<td><?php echo $key1; // file ?></td>
					<td><?php echo $key; // old-new key status ?></td>
					<td><?php echo $v1; // sha1 key value ?></td>
				</tr>
			<?php $i++; } ?>
		<?php } ?>
		</tbody>

	</table>
<?php } ?>

// VERSION 2: SORT BY PAIRS OLD-NEW [INCOMPLETE CODE]

<?php // Modified Files ?>
<?php if(!empty($diffs['alt'])) { ?>

	<h2><?php _e('Modified Files', 'advanced_file_monitor'); ?></h2>
	<table class="table">

		<thead>
			<tr>
				<th><?php _e('N', 'advanced_file_monitor'); ?></th>
				<th><?php _e('File', 'advanced_file_monitor'); ?></th>
				<th><?php _e('Key', 'advanced_file_monitor'); ?></th>
				<th><?php _e('SHA1', 'advanced_file_monitor'); ?></th>
			</tr>
		</thead>

		<tbody>

		<?php
			foreach($diffs['alt'] as $key => $value) {
				echo $key . '<br>';
				foreach($value as $filename => $hash) {
					echo $filename . '<br>';
					$rows = array_column($diffs['alt'], $filename);
					echo '<pre>';
					print_r($rows);
					echo '</pre>';
				}
			}
		?>

		</tbody>

	</table>
<?php } ?>