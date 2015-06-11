<?php

class Model_Publication_CWPP {
	
	protected $post_key = '_cwpp';
	protected $parent_post = false;
	protected $parent_id = false;
	protected $id = false;
	protected $number = '';
	protected $title = '';
	protected $subtitle = '';
	protected $authors = array();
	protected $abstract = '';
	protected $img_src = '';
	protected $is_peer_reviewed = false;
	protected $pdf_link = '';
	protected $content = '';
	protected $template = 'short-publication';
	
	// Gets
	public function get_post_key(){ return $this->post_key; }
	public function get_parent_post(){ return $this->parent_post; }
	public function get_parent_id(){ return $this->parent_id; }
	public function get_id(){ return $this->id; }
	public function get_number(){ return $this->number; }
	public function get_title(){ return $this->title; }
	public function get_subtitle(){ return $this->subtitle; }
	public function get_authors(){ return $this->authors; }
	public function get_abstract(){ return $this->abstract; }
	public function get_content(){ return $this->content; }
	public function get_is_peer_reviewed(){ return $this->is_peer_reviewed; }
	public function get_pdf_link(){ return $this->pdf_link; }
	public function get_template(){ return $this->template; }
	public function get_img_src(){ return $this->img_src; }
	
	// Sets
	public function set_parent_post( $post ){ $this->parent_post = $post; }
	public function set_parent_id( $id ){ $this->parent_id = $id; }
	public function set_id( $id ){ $this->id = $id; }
	public function set_number( $number ){ $this->number = $number; }
	public function set_title( $title ){ $this->title = $title; }
	public function set_subtitle( $subtitle ){ $this->subtitle = $subtitle; }
	public function set_authors( $authors ){ $this->authors = $authors; }
	public function set_abstract( $abstract ){ $this->abstract = $abstract; }
	public function set_content( $content ){ $this->content = $content; }
	public function set_is_peer_reviewed( $is_peer_reviewed ){ $this->is_peer_reviewed = $is_peer_reviewed; }
	public function set_pdf_link( $link ){ $this->pdf_link = $link; }
	public function set_img_src( $img_src ){ $this->img_src = $img_src; }
	
	// Builds
	public function build( $post ){
		
		// Set from post
		$this->set_id( $post->ID );
		$this->set_content( apply_filters( 'the_content' , $post->post_content ) );
		
		// Get the parent
		$parent = $this->service_get_parent( $post );
		
		// Set from parent
		$this->set_parent_post( $parent );
		$this->set_parent_id( $parent->ID );
		$this->set_title( apply_filters( 'the_title' , $parent->post_title ) );
		$this->set_abstract( $parent->post_excerpt );
		$this->set_pdf_link( get_permalink( $parent->ID ) );
		$this->set_img_src( $this->service_get_img_src() );
		
		// Get meta from parent
		$meta = get_post_meta( $parent->ID );
		
		// Set from meta
		$this->set_number( $this->service_get_meta( $meta, '_cwpp_number', '' ) );
		$this->set_subtitle( $this->service_get_meta( $meta, '_cwpp_subtitle', '' ) );
		$this->set_authors( $this->service_get_meta( $meta, '_cwpp_authors', '' ) );
		
	}
	
	// Services
	
	protected function service_get_img_src(){
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $this->get_parent_id() ), 'full' );
		
		return $image[0];
		
	}
	
	protected function service_get_parent( $post ){
		
		if ( ! $post->post_parent ) {
			
			$parent = $post;
			
		} else {
			
			$parent = get_post( $post->post_parent );
			
		} // end if
		
		return $parent;
		
	}
	
	protected function service_get_meta( $meta , $key , $default = false ){
		
		if ( empty( $meta[ $key ] ) ){
			
			return $default;
			
		} else {
			
			return $meta[ $key ][0];
			
		} // End if
		
	}
	
	
	/*private $is_top_page = false;
	
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
		
	}*/
	
	
}

