<fieldset id="cwpp-publication-basic-info" class="active">
	<p>
		<label>Subtitle</label><br />
		<input class="cwpp-full-width-input" type="text" name="_cwpp_subtitle" value="<?php echo $this->pub->get_subtitle(); ?>" />
	</p><p>
		<label>Summary/Abstract</label><br />
		<textarea class="cwpp-full-width-input" name="excerpt"><?php echo $this->pub->get_abstract(); ?></textarea>
	</p>
</fieldset>