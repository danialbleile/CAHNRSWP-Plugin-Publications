<?php 

class View_Publication_Editor_CWPP {
	
	private $publication;
	
	public function __construct( $publication ){
		
		$this->publication = $publication;
		
	}
	
	public function the_editor(){
		
		$html = '<div id="cwpp-publication">';
		
			$html .= '<input class="cwpp-medium-width-input cwpp-large-input" data-default="Enter Publication Number" type="text" name="_cwpp_number" value="' . $this->publication->get_number()  .'" />';
			
			$html .= '<a class="cwpp-link-button cwpp-standard-button" href="' . $this->publication->get_pdf_link() . '?pub-pdf=true" >View PDF</a>';
			
			if ( ! $this->publication->get_id() || $this->publication->get_parent_id() == $this->publication->get_id() ){
				
				$html .= $this->the_tabs();
			
				$html .= $this->the_basic_info();
				
			} else {
				
				$html .= '<a href="' . get_edit_post_link( $this->publication->get_parent_id() ) . '" class="cwpp-standard-button" >Edit Publication Settings</a>';
				
			}
            
			//$html .= '<a class="cwpp-link-button cwpp-standard-button" href="' . $this->publication->get_pdf_section_link() . '" >Section PDF</a>';
		
		$html .= '</div>';
		
		echo $html;
		
	}
	
	private function the_tabs(){
		
		$html = '<nav id="cwpp-publication-nav">';
		
		$tabs = array( 'Basic Info','Authors','Table of Contents');
		
		$active = 'active';
		
		foreach( $tabs as $tab ){
			
			$html .= '<a href="#" class="' . $active .'">' . $tab . '</a>';
			
			$active = '';
			
		}
		
		$html .= '</nav>';
		
		return $html;
		
	}
	
	private function the_basic_info(){
		
		ob_start();
		
		include CWPPDIR . 'inc/editor-section-basic.php';
		
		return ob_get_clean();
		
	}
}