<?php $button_path = src('images/', 'openseadragon');?>
<?php $unique_id = "openseadragon_".hash("md4", html_escape($record_name)); ?>
<div class="openseadragon-frame">
	<div class="openseadragon" id="<?php echo $unique_id; ?>">
		<script type="text/javascript">
			OpenSeadragon({
				id: "<?php echo $unique_id; ?>",
				prefixUrl: "<?php echo $button_path; ?>",
				sequenceMode: true,
				showReferenceStrip: true,
				referenceStripSizeRatio: 0.05,
				minZoomImageRatio: 0.8,
				maxZoomPixelRatio: 10,
				controlsFadeDelay: 1000,
				tileSources: <?php echo $tilesource; ?>
			});
		</script>
	</div>
</div>
