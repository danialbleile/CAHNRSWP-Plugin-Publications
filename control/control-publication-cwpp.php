<?php 

class Control_Publication_CWPP {
	
	private $publication;
		
	private $publication_view;
	
	public function __construct( $publication , $publication_view = false ){
		
		$this->publication = $publication;
		
		$this->publication_view = $publication_view;
		
	} // end __construct
	
	
	public function the_editor( $post ){
		
		$this->publication->build_publication( $post );
		
		$this->publication_view->the_editor();
		
		//var_dump( $this->publication );
		
	}
	
	public function get_publication( $post ){
		
		$this->publication->build_publication( $post );
		
		$html = $this->publication_view->output( false );
		
		return $html;
	}
	
	public function save( $post_id ){
		
		$this->publication->save_publication( $post_id );
		
	}
	
}