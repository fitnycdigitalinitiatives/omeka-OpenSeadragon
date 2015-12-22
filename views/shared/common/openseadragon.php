<?php $button_path = src('images/', 'openseadragon');?>
<?php $count = count($images); ?>
<?php if ($count == 1): ?>
	<?php $unique_id = "openseadragon_".hash("md4", html_escape($images[0]->getWebPath('original'))); ?>
	<div class="openseadragon-frame">
		<div class="openseadragon" id="<?=$unique_id?>">
			<script type="text/javascript">
				OpenSeadragon({
					id: "<?=$unique_id?>",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					navigatorSizeRatio: 0.1,
					minZoomImageRatio: 0.8,
					maxZoomPixelRatio: 1.5,
					controlsFadeDelay: 1000,
					tileSources: {
						type: 'legacy-image-pyramid',
						levels:<?php echo openseadragon_create_pyramid($images[0]); ?>
					}
				});
			</script>
		</div>
	</div>
<?php else: ?>
	<div class="openseadragon-frame">
		<div class="openseadragon" id="osd-sequence">
			<script type="text/javascript">
				OpenSeadragon.setString("Tooltips.NextPage", "Next");
				OpenSeadragon.setString("Tooltips.PreviousPage","Previous");
				OpenSeadragon({
					id: "osd-sequence",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					navigatorSizeRatio: 0.1,
					minZoomImageRatio: 0.8,
					maxZoomPixelRatio: 1.5,
					controlsFadeDelay: 1000,
					sequenceMode: true,
					showReferenceStrip: true,
					referenceStripSizeRatio: .1,
					tileSources: [
						<?php foreach($images as $image): ?>
						{type: 'legacy-image-pyramid',
						levels:<?php echo openseadragon_create_pyramid($image); ?>},
						<?php endforeach; ?>
					]
				});
			</script>
		</div>
	</div>
<?php endif; ?>
