<?php

class Publication_CWPP {
	
	public $pub_title;
	public $pub_subtitle;
	public $pub_abstract;
	public $pub_authors;
	public $pub_number;
	public $pub_chapters;
	public $pub_image_src;
	public $pub_is_peer_reviewed;
	public $pub_toc; // table of contents
	public $pub_template;
	
	/*
	* Build the pub using WP_Post object
	* --------------------------------------------------------------
	*/
	public function the_pub( $post ){
		
		// If is child page get the parent instead
		$post = $this->service_get_parent( $post );
		
		// Get the meta data for the pub
		$post_meta = get_post_meta( $post->ID );
		
		// Sets from $post
		
		$this->set_pub_title( $post );
		
		$this->set_pub_abstract( $post );
		
		$this->set_pub_image_src( $post->ID );
		
		$this->set_pub_chapters( $post );
		
		// Sets from $post_meta
		
		$this->set_pub_subtitle( $post_meta );
		
		$this->set_pub_authors( $post_meta );
		
		$this->set_pub_number( $post_meta );
		
		$this->set_pub_is_peer_reviewed( $post_meta );
		
		$this->set_pub_template( $post_meta );
		
	}
	
	/*
	* Set using WP_Post object
	* --------------------------------------------------------------
	*/
	
	public function set_pub_title( $post ){
		
		$this->pub_title = $post->post_title;
		
	} // end set_title
	
	
	public function set_pub_abstract( $post ){
		
		$this->pub_abstract = $post->post_excerpt;
		
	}
	
	public function set_pub_image_src( $post_id ){
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		
		$this->pub_image_src = $image[0];
		
	}
	
	public function set_pub_chapters( $post ){
		
		$chapters = array(
			array( 
				'title' => $post->post_title, 
				'content' => $post->post_content, 
			),
		);
		
		$children_args = array(
			'post_parent' => $post->ID,
			'post_type'   => 'publication',
			'post_status' => 'publish',
		);
		
		$children = get_children( $children_args );
		
		foreach( $children as $child ){
			
			$chapters[]  = array( 
				'title' => $child->post_title, 
				'content' => $child->post_content, 
			);
			
		} // end foreach
		
		$this->pub_chapters = $chapters;
		
	}
	
	/*
	* Set using Post Meta array
	* --------------------------------------------------------------
	*/
	
	public function set_pub_subtitle( $post_meta ){
		
		$subtitle = ( ! empty( $post_meta['_cwpp_subtitle'] ) )? $post_meta['_cwpp_subtitle'][0] : '';
		
		$this->pub_subtitle = $subtitle;
		
	} // end set_subtitle
	
	public function set_pub_authors( $post_meta ){
		
		$authors = ( ! empty( $post_meta['_cwpp_author'] ) )? $post_meta['_cwpp_author'][0] : '';
		
		$this->pub_authors = $authors;
		
	}
	
	public function set_pub_number( $post_meta ){
		
		$number = ( ! empty( $post_meta['_cwpp_number'] ) )? $post_meta['_cwpp_number'][0] : '';
		
		$this->pub_number = $number;
		
	}
	
	public function set_pub_is_peer_reviewed( $post_meta ){
		
		$is_peer_reviewed = ( ! empty( $post_meta['_cwpp_is_peer_reviewed'] ) )? $post_meta['_cwpp_is_peer_reviewed'][0] : false;
		
		$this->pub_is_peer_reviewed = $is_peer_reviewed;
		
	}
	
	public function set_pub_template( $post_meta ){
		
		$template = ( ! empty( $post_meta['_cwpp_template'] ) )? $post_meta['_cwpp_template'][0] : 'short-publication';
		
		$this->pub_template = $template;
		
	}
	
	/*
	* Services
	* --------------------------------------------------------------
	*/
	
	public function service_get_parent( $post ){
		
		if ( $post->post_parent ){
			
			$post = get_post( $post->post_parent );
			
		} // end if
		
		return $post;
		
	}
	
	
}