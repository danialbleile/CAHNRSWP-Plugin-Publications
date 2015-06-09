<?php 

class View_Publication_CWPP {
	
	private $publication;
	
	public function __construct( $publication ){
		
		$this->publication = $publication;
		
	}
	
	public function the_editor(){
		
		$disabled = ( $this->publication->check_is_top_page() )? '' : 'disabled'; 
		
		include CWPPDIR . 'inc/publication-after-title-parent.php';
		
	}
}