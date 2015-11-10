<?php

class Model_Publication_CWPP {
	
	protected $fields = array(
		'reviewed_month'   => array( 'value' => '' , 'type' => 'num' ),
		'reviewed_year'    => array( 'value' => '' , 'type' => 'num' ),
		'published_month'  => array( 'value' => '' , 'type' => 'num' ),
		'published_year'   => array( 'value' => '' , 'type' => 'num' ),
		'copyright'        => array( 'value' => '' , 'type' => 'num' ),
		'template'         => array( 'value' => '' , 'type' => 'text' ),
		'uses_pesticide'   => array( 'value' => 0 , 'type' => 'bool' ),
		'is_peer_reviewed' => array( 'value' => 1 , 'type' => 'bool' ),
	);
	
	protected $topics = array();
	
	
	
	
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
	protected $published_month = '';
	protected $published_year = '';
	protected $copyright = '';
	protected $uses_pesticide = '';
	protected $dates = array(
		'','January','Febuary','March','April','May','June','July','August','September','October','November','December',
	);
	
	// Gets
	public function get_field( $name ){
		
		if ( array_key_exists( $name , $this->fields ) ){
			
			return $this->fields[ $name ]['value'];
			
		} else {
			
			return '';
		}
		
	}
	public function get_fields() { return $this->fields; }
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
	public function get_published_month(){ return $this->published_month; }
	public function get_published_year(){ return $this->published_year; }
	public function get_copyright(){ return $this->copyright; }
	public function get_dates() { return $this->dates; }
	public function get_uses_pesticide() { return $this->uses_pesticide; }
	//New 
	public function get_topics(){ return $this->topics; }
	
	// Sets
	public function set_field( $name , $value ){
		
		if ( array_key_exists( $name , $this->fields ) ){
			
			$this->fields[ $name ]['value'] = $value;
			
		}
		
	}
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
	public function set_published_month( $date ){ $this->published_month = $date; }
	public function set_published_year( $date ){ $this->published_year = $date; }
	public function set_copyright( $copyright ){ $this->copyright = $copyright; }
	public function set_uses_pesticide( $uses_pesticide ){ $this->uses_pesticide = $uses_pesticide; }
	// New 
	public function set_topics( $topics ){ $this->topics = $topics; }
	
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
		$this->set_pdf_link( get_permalink( $parent->ID ) . '?pub-pdf=true' );
		$this->set_img_src( $this->service_get_img_src() );
		
		// Get meta from parent
		$meta = get_post_meta( $parent->ID );
		
		// Set from meta
		$this->set_number( $this->service_get_meta( $meta, '_cwpp_number', '' ) );
		$this->set_subtitle( $this->service_get_meta( $meta, '_cwpp_subtitle', '' ) );
		$this->set_authors( get_post_meta( $post->ID, '_cwpp_authors', true ) );
		$this->set_published_month( get_post_meta( $post->ID, '_cwpp_published_month', true ) );
		$this->set_published_year( get_post_meta( $post->ID, '_cwpp_published_year', true ) );
		$this->set_copyright( get_post_meta( $post->ID, '_cwpp_copyright', true ) );
		$this->set_is_peer_reviewed( get_post_meta( $post->ID, '_cwpp_is_peer_reviewed', true ) );
		$this->set_uses_pesticide( get_post_meta( $post->ID, '_cwpp_uses_pesticide', true ) );
		
		// New -------------------------------------------------------
		
		$topics_objs = get_the_terms( $parent->ID, 'topic' );
		
		$topics = array();
		
		if ( $topics_objs ){
		
			foreach( $topics_objs as $topic_obj ){
				
				$topics[] = $topic_obj->slug;
				
			} // end foreach
			
		} // end if
		
		$this->set_topics( $topics );
		
		
		$fields = $this->get_fields();
		
		//var_dump( $meta );
		
		foreach( $fields as $field_name => $field_data ){
			
			$field_key = '_cwpp_' . $field_name;
			
			if ( array_key_exists( $field_key , $meta ) ){
				
				if ( 'array' == $field_data['type'] ){
				} else {
					
					$this->set_field( $field_name , $meta[ $field_key ][0] );
					
				} // end if
				
			} // end if
			
		} // end foreach
		
	}
	
	public function utility_convert_month( $month ){
		
		if ( $month ){
			
			$dateObj = DateTime::createFromFormat('!m', $month );
		
			return $dateObj->format('F'); // March
		
		} else {
			
			return '';
			
		}
		
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

