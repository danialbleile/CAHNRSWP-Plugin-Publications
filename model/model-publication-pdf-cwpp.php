<?php

require_once 'model-publication-cwpp.php';

class Model_Publication_PDF_CWPP extends Model_Publication_CWPP {
	
	protected $chapters = array();
	
	//Gets
	public function get_chapters(){ return $this->chapters; }
	
	//Sets
	public function set_chapters( $chapters ) { $this->chapters = $chapters; }
	
	// Builds
	public function build( $post ){
		
		parent::build( $post );
		
		$this->set_chapters( $this->service_get_children( $post ) );
		
	}
	
	private function service_get_children( $post ){
		
		$child_array = array( $post->ID => $post );
		
		if ( $this->get_parent_post() ){
			
			$args = array(
				'post_parent' => $this->get_parent_id(),
				'post_type'   => 'publication', 
				'numberposts' => -1,
				'post_status' => 'publish' 
			); 
			
			
			$children = get_children( $args );
			
			$child_array = array_merge( $child_array , $children );
			
			
		}// end if
		
		return $child_array;
		
	}
	
	
	
		
	
}