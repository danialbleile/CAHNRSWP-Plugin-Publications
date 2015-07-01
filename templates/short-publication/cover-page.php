<div id="cover-page" class="<?php echo implode( ' ' , $this->pub->get_topics() );?>">
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
        	<?php 
			
			$html = 'By<br />';
			
			$authors = $this->pub->get_authors();
			
			$split = '';
			
			foreach( $authors as $author ){
				
				$html .= $split;
				
				if ( ! empty( $author['f_name'] ) ){
					
					$html .= '<strong>' . $author['f_name'] . '</strong>';
					
				} // end if
				
				if ( ! empty( $author['m_name'] ) ){
					
					$html .= ' <strong>' . $author['m_name'] . '</strong>';
					
				} // end if
				
				if ( ! empty( $author['l_name'] ) ){
					
					$html .= ' <strong>' . $author['l_name'] . '</strong>';
					
				} // end if
				
				if ( ! empty( $author['title'] ) ){
					
					$html .= ', ' . $author['title'];
					
				} // end if
				
				if ( ! empty( $author['aff'] ) ){
					
					$html .= ', ' . $author['aff'];
					
				} // end if
				
				$split = ', ';
				
			} // end foreach
			
			echo $html;
			
			?>
        </div>
    </footer>
    <div class="pub-peer-reviewed">
        <img src="<?php echo CWPPURL ;?>images/peer-reviewed-logo.png" >
        <div class="pub-number">
            <?php echo $this->pub->get_number();?>
        </div>
    </div>
</div>