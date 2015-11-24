<?php $button_path = src('images/', 'openseadragon');?>
<?php $count = count($images); ?>
<?php if ($count == 1): ?>
	<div class="openseadragon-frame">
		<div class="openseadragon" id="osd-single">
			<script type="text/javascript">
				OpenSeadragon({
					id: "osd-single",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					minZoomImageRatio: 0.8,
					maxZoomPixelRatio: 1.5,
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
				OpenSeadragon({
					id: "osd-sequence",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					minZoomImageRatio: 0.8,
					maxZoomPixelRatio: 1.5,
					sequenceMode: true,
					showReferenceStrip: true,
					referenceStripSizeRatio: .1,
					previousButton: 'Previous',
					nextButton: 'Next',
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
