<?php 

class View_Publication_CWPP {
	
	private $publication;
	
	public function __construct( $publication ){
		
		$this->publication = $publication;
		
	}
	
	public function the_editor(){
		
		$html = '<div id="cwpp-publication">';
		
			$pub_number = ( $this->publication->get_number() ) ? $this->publication->get_number() : 'Enter Publication Number';
		
			$html .= '<input class="cwpp-full-input cwpp-large-input" type="text" name="_cwpp_number" value="' . $pub_number  .'" />';
		
		$html .= '</div>';
		
		echo $html;
		
	}
	
	public function the_tabs(){
		
		$html = '<nav id="cwpp-publication-info">';
		
		$tabs = array( 'Basic Info','Authors','Table of Contents');
		
		foreach( $tabs as $tab ){
			
			$html .= '<a href="#">' . $tab . '</a>';
			
		}
		
		$html .= '</nav>';
		
		return $html;
		
	}
}