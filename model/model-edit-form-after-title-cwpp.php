<?php

class Model_Edit_Form_After_Title_CWPP {
	
	private $children;
	
	private $title;
	
	private $slug;
	
	
	// Gets
	
	// Sets
	
	/**
	 * @desc: Sets all of the class properties in one call
	 * @param $post ( object ): The WP_Post object
	**/
	public function set_edit_form( $post ){} // end set_edit_form
	
	public function set_children( $post ){}
	
	public function set_title( $post ){ $this->title = $post->post_title; }
	
	public function set_slug( $post ){ $this->slug = $post->post_name; }
	
	// Services
	
}