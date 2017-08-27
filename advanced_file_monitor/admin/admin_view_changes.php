<?php if ( ( !defined('OC_ADMIN') || OC_ADMIN!==true ) ) exit('Access is not allowed.'); ?>

<?php
	if (Params::getParam('afmAction') === 'clear') {
		// reset reference snapshot & differences
		osc_set_preference('afm_files', '', 'advanced-file-monitor', 'STRING');
		osc_set_preference('afm_diffs', '', 'advanced-file-monitor', 'STRING');

		// re-scan
		afm_scan();

		header('Location: ' . osc_admin_base_url(true) . '?page=plugins&action=renderplugin&route=afm-settings');
	}
?>

<?php
	// get difference
	$diffs = afm_get_diffs();
?>

<div>

	<!-- Quick Jump Buttons -->
	<div style="clear:none; display:block; float:left;">
		<!-- Modified Files Button -->
		<a class="btn btn-submit" style="text-align:center; width:60px;" href="#mod"><?php _e('MODIFIED', 'advanced_file_monitor'); ?></a>

		<!-- New Files Button -->
		<a class="btn btn-submit" style="text-align:center; width:60px;" href="#new"><?php _e('NEW', 'advanced_file_monitor'); ?></a>

		<!-- Deleted Files Button -->
		<a class="btn btn-submit" style="text-align:center; width:60px;" href="#del"><?php _e('DELETED', 'advanced_file_monitor'); ?></a>
	</div>

	<!-- System Commands Buttons -->
	<div style="clear:none; display:block; float:right;">
		<!-- Clear Button -->
		<a id="clear-scan-results" class="btn btn-submit" style="text-align:center; width:60px; background-color:#FF7500;" href="<?php echo osc_admin_base_url('true') . '?page=plugins&action=renderplugin&file=advanced_file_monitor/admin/admin_view_changes.php&afmAction=clear'; ?>"><?php _e('CLEAR', 'advanced_file_monitor'); ?></a>

		<script>
		// prevent double mouse click
		$(document).ready(function() {
			$("#clear-scan-results").dblclick(function(e) {
				e.preventDefault();
			});
		});
		</script>

		<!-- Return Button -->
		<?php if(osc_version() >= 320 ) { ?>
				<a class="btn btn-submit" style="text-align:center; width:60px;" href="<?php echo osc_route_admin_url('afm-settings'); ?>"><?php _e('RETURN', 'advanced_file_monitor'); ?></a>
			<?php } else { ?>
				<a class="btn btn-submit" style="text-align:center; width:60px;" href="<?php echo osc_admin_render_plugin_url('advanced_file_monitor/admin/admin_settings.php'); ?>"><?php _e('RETURN', 'advanced_file_monitor'); ?></a>
			<?php } ?>
	</div>

</div>

<div class="clear"></div>
<br><br>

<!-- Modified Files -->
<?php if (!empty($diffs['alt'])) { ?>
	<h2 id="mod"><?php _e('Modified Keys', 'advanced_file_monitor'); ?></h2>
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
		<?php foreach ($diffs['alt'] as $key => $v) { ?>
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

<!-- New Files -->
<?php if (!empty($diffs['add'])) { ?>
	<h2 id="new"><?php _e('New Keys', 'advanced_file_monitor'); ?></h2>
	<table class="table">
		<thead>
			<tr>
				<th><?php _e('N', 'advanced_file_monitor'); ?></th>
				<th><?php _e('File', 'advanced_file_monitor'); ?></th>
				<th><?php _e('SHA1', 'advanced_file_monitor'); ?></th>
			</tr>
		</thead>

		<tbody>
		<?php $i = 1; ?>
		<?php foreach ($diffs['add'] as $add => $addV) {	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td style="color:#00F;"><?php echo $add; ?></td>
				<td><?php echo $addV; ?></td>
			</tr>
		<?php $i++; } ?>
		</tbody>
	</table>
<?php } ?>

<!-- Deleted Files -->
<?php if (!empty($diffs['del'])) { ?>
	<h2 id="del"><?php _e('Deleted Keys', 'advanced_file_monitor'); ?></h2>
	<table class="table">
		<thead>
			<th><?php _e('N', 'advanced_file_monitor'); ?></th>
			<th><?php _e('File', 'advanced_file_monitor'); ?></th>
			<th><?php _e('SHA1 key', 'advanced_file_monitor'); ?></th>
		</thead>

		<tbody>
		<?php $i = 1; ?>
		<?php foreach ($diffs['del'] as $del => $delV) {	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td style="color:#F00;"><?php echo $del; ?></td>
				<td><?php echo $delV; ?></td>
			</tr>
		<?php $i++; } ?>
		</tbody>
	</table>
<?php } ?>

<!-- Debug Section -->

<?php
/*
	// get difference
	$diffs = afm_get_diffs();

		// array debug
		echo '<pre>';
		print_r($diffs);
		echo '</pre>';
*/
?>
