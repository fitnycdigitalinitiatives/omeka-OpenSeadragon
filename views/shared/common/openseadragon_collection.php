<?php $button_path = src('images/', 'openseadragon');?>
<?php $unique_id = "openseadragon_".hash("md4", html_escape($record_name)); ?>
<div class="openseadragon-frame">
	<div class="openseadragon" id="<?php echo $unique_id; ?>">
		<script type="text/javascript">
			OpenSeadragon({
				id: "<?php echo $unique_id; ?>",
				prefixUrl: "<?php echo $button_path; ?>",
				showNavigator: true,
				collectionMode: true,
    		collectionRows: 1,
				navigatorSizeRatio: 0.1,
				minZoomImageRatio: 0.8,
				maxZoomPixelRatio: 10,
				controlsFadeDelay: 1000,
				tileSources: <?php echo $tilesource; ?>
			});
		</script>
	</div>
</div>