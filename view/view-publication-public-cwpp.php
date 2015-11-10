<?php 

class View_Publication_Public_CWPP {
	
	private $publication;
	
	public function __construct( $publication ){
		
		$this->publication = $publication;
		
	}
	
	public function the_banner(){
	}
	
	public function the_details(){
		
		$html = '<div id="publication-details">';
		
			$html .= '<nav>';
			
				$html .= '<a href="#" class="active">Abstract</a>';
			
			$html .= '</nav>';
			
			$html .= '<div class="section">';
				
				$html .= '<div>' . $this->publication->get_abstract() . '</div>';
			
			$html .= '</div>';
		
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_logo(){
		
		$html = '<div id="publication-logo">';
		
			$html .= '<img src="' . CWPPURL . '/images/peer-reviewed-logo.png" >';
			
			$html .= '<div id="publication-number">' . $this->publication->get_number() . '</div>';
			
			$html .= '<a href="' . $this->publication->get_pdf_link() . '">Download</a>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_indicia(){
		
		$html = '<div id="indicia"><p>Use pesticides with care. Apply them only to plants, animals, or sites as listed on the label. When mixing and applying
pesticides, follow all label precautions to protect yourself and others around you. It is a violation of the law to disregard
label directions. If pesticides are spilled on skin or clothing, remove clothing and wash skin thoroughly. Store
pesticides in their original containers and keep them out of the reach of children, pets, and livestock.</p><p>
Copyright 2014 Washington State University</p><p>
WSU Extension bulletins contain material written and produced for public distribution. Alternate formats of our
educational materials are available upon request for persons with disabilities. Please contact Washington State
University Extension for more information.</p><p>
Issued by Washington State University Extension and the U.S. Department of Agriculture in furtherance of the Acts of
May 8 and June 30, 1914. Extension programs and policies are consistent with federal and state laws and regulations
on nondiscrimination regarding race, sex, religion, age, color, creed, and national or ethnic origin; physical, mental, or
sensory disability; marital status or sexual orientation; and status as a Vietnam-era or disabled veteran. Evidence of
noncompliance may be reported through your local WSU Extension office. Trade names have been used to simplify
information; no endorsement is intended. Published September 2014.</p></div>';

	return $html;
		
	}
}