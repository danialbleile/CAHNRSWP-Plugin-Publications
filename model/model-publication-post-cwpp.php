<?php

require_once 'model-publication-cwpp.php';

class Model_Publication_Post_CWPP extends Model_Publication_CWPP {
	
	private $image_url;
	
	public function get_image_url() { return $this->image_url; }
	
	public function set_image_url( $url ) { $this->image_url = $url; }
	
	
	
	
	public function build_publication( $post ){
		
		$parent_post = $this->service_get_parent_post( $post );
		
		if ( $post->ID == $parent_post->ID ) $this->set_is_top_page( true );
		
		$fields = $this->service_get_fields( $parent_post->ID );
		
		$this->build_from_current( $post , $fields );
		
		$this->build_from_parent( $parent_post , $fields );
		
	}
	
	public function build_from_parent( $parent_post , $fields = array() ){
		
		$this->set_title( $parent_post->post_title );
		
		$this->set_image_url( $this->service_get_image_url( $parent_post->ID ) );
		
		$this->set_abstract( $parent_post->post_excerpt );
		
		$this->set_pdf_link( get_permalink( $parent_post->ID ) . '?publication_template=short-publication' );
		
		if ( ! empty( $fields[ '_cwpp_number' ] ) ) $this->set_number( $fields[ '_cwpp_number' ] );
		
		if ( ! empty( $fields[ '_cwpp_subtitle' ] ) ) $this->set_subtitle( $fields[ '_cwpp_subtitle' ] );
		
	}
	
	public function build_from_current( $post, $fields = array() ){
		
		$this->set_pdf_section_link( get_permalink( $post->ID ) . '?publication_template=section-publication' );
		
		$this->set_current_post( $post );
		
	}
	
	// Services
	
	private function service_get_excerpt( $post ){
		
		if ( isset( $post->post_excerpt ) &&  $post->post_excerpt ){
			
			$excerpt = $post->post_excerpt;
			
		} else {
			
			$excerpt = '';
			
		} // end if
		
		return $excerpt;
		
	}
	
	private function service_get_image_url( $post_id ){
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		
		return $image[0];
		
	}
	
	
}