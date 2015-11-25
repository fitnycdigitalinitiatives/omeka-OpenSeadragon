<h2>Admin Theme</h2>

<div class="field">
    <div id="openseadragon_embed_admin_label" class="two columns alpha">
        <label for="openseadragon_embed_admin"><?php echo __('Embed viewer in admin item show pages?'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <?php echo $this->formCheckbox('openseadragon_embed_admin', null, 
        array('checked' => (bool) get_option('openseadragon_embed_admin'))); ?>
    </div>
</div>

<h2>Public Theme</h2>

<div class="field">
    <div id="openseadragon_embed_public_label" class="two columns alpha">
        <label for="openseadragon_embed_public"><?php echo __('Embed viewer in public item show pages?'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <?php echo $this->formCheckbox('openseadragon_embed_public', null, 
        array('checked' => (bool) get_option('openseadragon_embed_public'))); ?>
    </div>
</div>
