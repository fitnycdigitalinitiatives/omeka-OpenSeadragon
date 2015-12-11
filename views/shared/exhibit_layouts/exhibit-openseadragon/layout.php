<?php
$position = isset($options['file-position'])
    ? html_escape($options['file-position'])
    : 'left';
$size = isset($options['file-size'])
    ? html_escape($options['file-size'])
    : 'fullsize';
$captionPosition = isset($options['captions-position'])
    ? html_escape($options['captions-position'])
    : 'center';
?>
<div class="row">
	<div class="col-sm-3 col-sm-offset-3">
	<h1><?php echo metadata('exhibit_page', 'title'); ?></h1>
	<?php echo $text; ?>
	</div>
	<div class="col-sm-7">
    <?php foreach ($attachments as $attachment): ?>
        <?php $file = $attachment->getFile(); ?>
		<?php echo $this->openseadragon($file); ?>
    <?php endforeach; ?>
	</div>
</div>