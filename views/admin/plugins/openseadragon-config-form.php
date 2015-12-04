<h2>Embed Options</h2>

<div class="field">
    <div id="openseadragon_embed_public_label" class="two columns alpha">
        <label for="openseadragon_embed_public"><?php echo __('Embed viewer in public item show pages via fire_plugin_hook (else view must be embedded manually using openseadragon function?'); ?></label>
    </div>
    <div class="inputs five columns omega">
        <?php echo $this->formCheckbox('openseadragon_embed_public', null, 
        array('checked' => (bool) get_option('openseadragon_embed_public'))); ?>
    </div>
</div>
