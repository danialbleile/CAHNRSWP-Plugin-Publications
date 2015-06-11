<div id="cover-page">
	<div class="pub-section-inner">
    	<img class="primary-logo" src="<?php echo CWPPURL ;?>images/wsu-extension-logo.jpg" ><br />
        <img class="primary-image" src="<?php echo $this->pub->get_img_src(); ?>" ><br />
        <header class="primary-header">
        	<div class="primary-title">
            	<?php echo $this->pub->get_title(); ?>
            </div>
            <div class="primary-subtitle">
            	<?php echo $this->pub->get_subtitle();?>
            </div>
        </header>
    </div>
    <footer id="cover-footer">
    	<div class="pub-authors">
        </div>
        <div class="pub-peer-reviewed">
        	<img src="<?php echo CWPPURL ;?>images/peer-reviewed-logo.png" >
            <div class="pub-number">
            	<?php echo $this->pub->get_number();?>
            </div>
        </div>
    </footer>
</div>