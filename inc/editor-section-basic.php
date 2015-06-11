<fieldset id="cwpp-publication-basic-info">
	<p>
		<label>Subtitle</label><br />
		<input class="cwpp-full-width-input" type="text" name="_cwpp_subtitle" value="<?php echo $this->publication->get_subtitle(); ?>" />
	</p><p>
		<label>Summary/Abstract</label><br />
		<textarea class="cwpp-full-width-input" name="excerpt"><?php echo $this->publication->get_abstract(); ?></textarea>
	</p><p class="cwpp-inline-fields">
		<input type="checkbox" name="_cwpp_is_peer_reviewed" value="1" <?php checked( $this->publication->get_is_peer_reviewed() ); ?>/>
		<label> Peer Reviewed</label>
	</p><p>
		<label>Template </label>
		<select name="_cwpp_template" >
			<option value="short-publication" >Short Publication</option>
		</select>
	</p>
</fieldset>