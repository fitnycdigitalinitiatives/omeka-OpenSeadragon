<?php $button_path = src('images/', 'openseadragon');?>
<?php $count = count($images); ?>
<?php if ($count = 1): ?>
	<div class="openseadragon-frame">
		<div class="openseadragon" id="osd-single">
			<script type="text/javascript">
				OpenSeadragon({
					id: "osd-single",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					tileSources: {
						type: 'legacy-image-pyramid',
						levels:<?php echo openseadragon_create_pyramid($image); ?>
					}
				});
			</script>
		</div>
	</div>
<?php else: ?>
	<div class="openseadragon-frame">
		<div class="openseadragon" id="osd-single">
			<script type="text/javascript">
				OpenSeadragon({
					id: "osd-single",
					prefixUrl: "<?=$button_path?>",
					showNavigator: true,
					sequenceMode: true,
					showReferenceStrip: true,
					tileSources: [
						<?php foreach($images as $image): ?>
						{type: 'legacy-image-pyramid',
						levels:<?php echo openseadragon_create_pyramid($image); ?>},
					]
				});
			</script>
		</div>
	</div>
<?php foreach($images as $image): ?>
<?php endforeach; ?>
<?php endif; ?>
