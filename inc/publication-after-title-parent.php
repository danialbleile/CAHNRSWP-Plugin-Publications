<section id="cwpp-publication">
	<fieldset class="cwpp-core-settings">
    	<p>
			<label>Publication Number: </label><input type="text" name="_cwpp_number" value="<?php echo $this->publication->get_number();?>" />
            <a class="cwpp-link-button cwpp-standard-button" href="<?php echo $this->publication->get_pdf_link();?>" >Publication PDF</a>
            <a class="cwpp-link-button cwpp-standard-button" href="<?php echo $this->publication->get_pdf_section_link();?>" >Section PDF</a>
		</p>
    </fieldset>
    <h4>Basic Info</h4>
	<fieldset class="cwpp-basic-settings cwpp-group">
    	<div class="cwpp-fieldset-inner">
        	<p>
            <label>Title</label><br />
            <input class="cwpp-input-full" type="text" name="" value="<?php echo $this->publication->get_title();?>" <?php echo $disabled;?>/>
            </p><p>
            <label>Sub Title</label><br />
            <input class="cwpp-input-full" type="text" name="_cwpp_subtitle" value="<?php echo $this->publication->get_subtitle();?>" <?php echo $disabled;?>/>
            </p><p>
            	<label>Summary/Abstract</label><br />
            	<textarea class="cwpp-input-full" type="text" name="excerpt" <?php echo $disabled;?>><?php echo $this->publication->get_abstract();?></textarea>
            </p><p>
            <input type="checkbox" name="_cwpp_is_peer_reviewed" value="1" <?php echo $disabled;?>/> <label>Is Peer Reviewed</label>
            </p>
        </div>
    </fieldset>
    <h4>Publication Details</h4>
	<fieldset class="cwpp-basic-settings cwpp-group">
    	<div class="cwpp-fieldset-inner">
        	<p>
            	<label>Authors</label><br />
            </p>
        </div>
    </fieldset>

</section>
<script>

</script>