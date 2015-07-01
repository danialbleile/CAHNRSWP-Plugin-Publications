<section id="indicia-page">
	<div class="pub-section-inner">
    	<div class="pub-content-bottom">
      <p>
      <img class="primary-logo" src="<?php echo CWPPURL ;?>images/wsu-extension-logo.jpg" >
      </p>
      <?php if ( $this->pub->get_field('uses_pesticide') ) :?>
      <p>Use pesticides with care. Apply them only to plants, animals, or sites as listed on the label. When mixing and applying pesticides, follow all label precautions to protect yourself and others around you. It is a violation of the law to disregard label directions. If pesticides are spilled on skin
        
        or clothing, remove clothing and wash skin thoroughly. Store pesticides in their original containers and keep them out of the reach of children, 
        
        pets, and livestock.</p><?php endif;?>
      <p>Copyright <?php echo $this->pub->get_field('copyright');?> Washington State University        </p>
      <p>WSU Extension bulletins contain material written and produced for public distribution. Alternate formats of our educational materials are available upon request for persons with disabilities. Please contact Washington State University Extension for more information.        </p>
      <p>Issued by Washington State University Extension and the U.S. Department of Agriculture in furtherance of the Acts of May 8 and June 30, 1914. 
        
        Extension programs and policies are consistent with federal and state laws and regulations on nondiscrimination regarding race, sex, religion, 
        
        age, color, creed, and national or ethnic origin; physical, mental, or sensory disability; marital status or sexual orientation; and status as a 
        
        Vietnam-era or disabled veteran. Evidence of noncompliance may be reported through your local WSU Extension office. Trade names have been 
        
        used to simplify information; no endorsement is intended. Published <?php echo $this->pub->utility_convert_month( $this->pub->get_field('published_month') ). ' ' . $this->pub->get_field('published_year');?>.
        <?php
			
			$reviewed_year = $this->pub->get_field('reviewed_year');
			
			if ( $reviewed_year ){
				
				echo 'Reviewed ' . $this->pub->utility_convert_month( $this->pub->get_field('reviewed_month') );
				
				echo ' ' . $reviewed_year . '.';
				
			} // end if
		
        ?></p>
      <p>&nbsp;</p>
      <p><strong><?php echo strtoupper( $this->pub->pub_number ); ?></strong></p>
      </div>
	</div>
</section>