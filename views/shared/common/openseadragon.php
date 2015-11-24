<?php $button_path = src('images/', 'openseadragon');?>
<div class="openseadragon">
    <?php
    foreach($images as $image):
        $image_url = html_escape($image->getWebPath('original'));
        $unique_id = "openseadragon_".hash("md4", $image_url);
       ?>
    <div class="openseadragon_viewer" id="<?=$unique_id?>">
        <img src="<?=$image_url?>" class="openseadragon-image tmp-img" alt="">
    </div>

    <script type="text/javascript">
        OpenSeadragon({
			id: "<?=$unique_id?>",
			prefixUrl: "<?=$button_path?>",
			showNavigator: true,
			tileSources: {
				type: 'legacy-image-pyramid',
				levels:<?php echo openseadragon_create_pyramid($image); ?>
			}
		});
    </script>
    <?php endforeach; ?>
</div>