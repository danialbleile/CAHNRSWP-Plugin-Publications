<?php

class Model_Publication_CWPP {
	
	private $is_top_page = false;
	
	private $is_peer_reviewed = false;
	
	private $first_post;
	
	private $current_post;
	
	private $number = '';
	
	private $title = '';
	
	private $subtitle = '';
	
	private $current_title = '';
	
	private $abstract = '';
	
	private $authors = array();
	
	private $chapters = array();
	
	private $price = '';
	
	private $content_types = array();
	
	private $categories = array();
	
	private $template = '';
	
	private $link = '';
	
	private $current_link = '';
	
	private $pdf_link = '';
	
	private $pdf_section_link = '';
	
	private $pub_data = array(
		'_cwpp_number' => array( 'default' => '' , 'type' => 'text' ),
		'_cwpp_subtitle' => array( 'default' => '' , 'type' => 'text' ),
		'_cwpp_authors' => array( 'default' => array() , 'type' => 'array' ),
		'_cwpp_is_peer_reviewed' => array( 'default' => false , 'type' => 'bool' ),
		'_cwpp_price' => array( 'default' => '', 'type' => 'int' ),
		'_cwpp_template' => array( 'default' => 'basic' , 'type' => 'text' ),
	);
	
	// Checks
	public function check_is_top_page() { return $this->is_top_page; }
	
	// Gets
	public function get_title(){ return $this->title;}
	public function get_number(){ return $this->number; }
	public function get_subtitle(){ return $this->subtitle; }	
	public function get_pub_data(){ return $this->pub_data; }
	public function get_abstract(){ return $this->abstract; }
	public function get_authors() { return $this->authors; }
	public function get_chapters() { return $this->chaptors; }
	public function get_is_peer_reviewed() { return $this->is_peer_reviewed; }
	public function get_price() { return $this->price; }
	public function get_content_types() { return $this->content_types; }
	public function get_template(){ return $this->template; }
	public function get_link(){ return $this->link; }
	public function get_current_link() { return $this->current_link; }
	public function get_pdf_link() { return $this->pdf_link; }
	public function get_pdf_section_link() { return $this->pdf_section_link; }
	
	// Sets
	
	
	public function set_is_top_page( $bool ) { $this->is_top_page = $bool; }
	public function set_first_post( $post ) { $this->first_post = $post; }
	public function set_current_post( $post ) { $this->current_post = $post; }
	public function set_title( $title ){ $this->title = $title;}
	public function set_number( $number ){ $this->number = $number; }
	public function set_subtitle( $subtitle ){ $this->subtitle = $subtitle; }	
	public function set_abstract( $abstract ){ $this->abstract = $abstract; }
	public function set_authors( $authors ) { $this->authors = $authors; }
	public function set_chapters( $chapters ) { $this->chaptors = $chapters; }
	public function set_is_peer_reviewed( $is_peer_reviewed ) { $this->is_peer_reviewed = $is_peer_reviewed; }
	public function set_price( $price ) { $this->price = $price; }
	public function set_content_types( $content_types ) { $this->content_types = $content_types; }
	public function set_template( $template ){ $this->template = $template; }
	public function set_link( $link ){ $this->link = $link; }
	public function set_current_link( $current_link ) { $this->current_link = $current_link; }
	public function set_pdf_link( $pdf_link ) { $this->pdf_link = $pdf_link; }
	public function set_pdf_section_link( $pdf_section_link ) { $this->pdf_section_link = $pdf_section_link; }
	
	// Handlers
	
	
	
	
	
	// Handlers
	public function from_wp_submit(){
		
		$fields = $this->service_get_fields();
		
		$this->set_number( $fields['_cwpp_number'] );
		
	}
	
	
	// Services
	protected function service_get_fields( $post_id = false ){
		
		$data_set = $this->get_pub_data();
		
		$fields = array(); // populate below
		
		$meta = ( $post_id )? get_post_meta( $post_id ) : array();
		
		foreach( $data_set as $key => $value ){
			
			if ( $post_id ){
				
				if ( ! empty( $meta[ $key ][0] ) ){
					
					$fields[ $key ] = $meta[ $key ][0];
					
				} else {
					
					$fields[ $key ] = $value['default'];
					
				} // end if
				
			} else {
				
				if ( isset( $_POST[ $key ] ) ){
					
					switch( $value['type'] ){
						
						case 'text':
							$clean = sanitize_text_field( $_POST[ $key ] );
						
					} // end switch
					
					if ( isset( $clean ) ){
					
						$fields[ $key ] = $clean;
					
					} else {
						
						$fields[ $key ] = $value['default'];
						
					}// end if 
					
				} else {
					
					$fields[ $key ] = $value['default'];
					
				}// end if
				
			} // end if
			
		} // end foreach
		
		return $fields;
		
	}
	
	//If post has parent, get parent otherwise current post is parent
	protected function service_get_parent_post( $post ){
		
		if ( is_object ( $post ) ){
			
			var_dump( $post );
		
			if ( isset( $post->post_parent ) && $post->post_parent ){
				
				$parent_post = get_post( $post->post_parent );
				
			} else {
				
				$parent_post = $post;
				
			} // end if
		
		} else {
			
			if ( $post ){
			
				$args = array(
					'post_type'   => 'publication',
					'name'    => $post,
					'post_status' => 'any',
					);
				
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ){
					
					while ( $query->have_posts() ){
						
						$query->the_post();
						
						$parent_post = $query->post;
						
						break;
						
					} // end while
					
				} else {
					
					$parent_post = '';
					
				} // end if
				
				wp_reset_postdata();
				
			} else {
				
				$parent_post = '';
				
			}
			
		}
		
		return $parent_post;
		
	}
	
	
}

