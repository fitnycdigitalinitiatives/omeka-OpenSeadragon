<?php $button_path = src('images/', 'openseadragon');?>
<?php $unique_id = "openseadragon_".hash("md4", html_escape(metadata($item, array('Item Type Metadata', 'Record Name')))); ?>
<div class="openseadragon-frame">
	<div class="openseadragon" id="<?php echo $unique_id; ?>">
		<script type="text/javascript">
			OpenSeadragon({
				id: "<?php echo $unique_id; ?>",
				prefixUrl: "<?php echo $button_path; ?>",
				showNavigator: true,
				navigatorSizeRatio: 0.1,
				minZoomImageRatio: 0.8,
				maxZoomPixelRatio: 10,
				controlsFadeDelay: 1000,
				tileSources: {
					type: 'legacy-image-pyramid',
					levels:<?php echo openseadragon_create_mdid_pyramid($item); ?>
				}
			});
		</script>
	</div>
</div>
