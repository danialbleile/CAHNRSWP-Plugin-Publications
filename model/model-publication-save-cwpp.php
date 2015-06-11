<?php

require_once 'model-publication-cwpp.php';

class Model_Publication_Save_CWPP extends Model_Publication_CWPP {
	
	
	// Builds
	public function build( $post_id ){
		
		// Set from current
		$this->set_id( $post_id );
		
		$number = $this->service_get_post( '_cwpp_number' );
		if ( NULL !== $number ) $this->set_number( $number );
		
		$parent = $this->service_get_parent( $post_id , $this->get_number() );
		
		if ( $parent ){
			
			$this->set_parent_post( $parent );
		
			$this->set_parent_id( $parent->ID );
			
		} // end if
		
		
		
		
		
		
		
		
		/*
		$subtitle = $this->service_get_post( '_cwpp_subtitle' );
		if ( NULL !== $subtitle ) $this->set_subtitle( $subtitle );
		
		$authors = $this->service_get_post( '_cwpp_authors' , 'array' );
		if ( NULL !== $authors ) $this->set_authors( $authors );
		
		$peer_reviewed = $this->service_get_post( '_cwpp_is_peer_reviewed' , 'bool' );
		if ( NULL !== $peer_reviewed ) $this->set_is_peer_reviewed( $peer_reviewed );*/
		
		
		// Get the parent
		//$parent = $this->service_get_parent( $post_id );
		
		// Set from parent
		//$this->set_parent_id( $parent->ID );
		//$this->set_title( apply_filters( 'the_title' , $parent->post_title ) );
		//$this->set_abstract( $parent->post_excerpt );
		
		// Get meta from parent
		//$meta = get_post_meta( $parent->ID );
		
		// Set from meta
		//$this->set_number( $this->service_get_meta( $meta, '_cwpp_number', '' ) );
		//$this->set_subtitle( $this->service_get_meta( $meta, '_cwpp_subtitle', '' ) );
		//$this->set_authors( $this->service_get_meta( $meta, '_cwpp_authors', '' ) );
		
	}
	
	public function service_get_parent( $post_id ) {
		
		$pub_number = $this->get_number();
		
		if ( ! $pub_number ){
			
			$parent_post = false;
			
		} else {
			
			$parent_post = get_page_by_path( strtolower( $pub_number ),OBJECT, 'publication');
			
		}
		
		return $parent_post;
		
	}
	
	private function service_get_post( $key , $type = 'text' ){
		
		if ( ! empty( $_POST[ $key ] ) ){
			
			$clean_data = NULL;
			
			$data = $_POST[ $key ];
			
			switch( $type ){
				
				default:
					$clean_data = sanitize_text_field( $data );
					break;
			} // end switch
			
		} else {
			
			$clean_data = NULL;
			
		} // end if
		
		return $clean_data;
		
	}
	
	
	public function save( $post_id ){
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
		
			return; 
			
		} // end if
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'publication' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				
				return;
				
			} // end if
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				
				return;
				
			} // end if
			
		} //  end if
		
		$fields = array();
		
		$fields['_cwpp_number'] = $this->get_number();
		
		if ( $this->get_number() ){
			
			$parent = $this->get_parent_post();
			
			$update_post = array();
			
			$update_post['ID'] = $post_id;
			
			if ( $parent && $parent->ID != $this->get_id() ){ // Is child
			
				$update_post['post_parent'] = $parent->ID;
			
			} else { // Is parent
			
				$fields['_cwpp_subtitle'] = $this->get_subtitle();
				
				$fields['_cwpp_authors'] = $this->get_authors();
				
				$fields['is_peer_reviewed'] = $this->get_is_peer_reviewed();
			
				$update_post['post_name'] = $this->get_number();
			
			} // end if
			
			foreach( $fields as $key => $value ){
			
				update_post_meta( $post_id , $key , $value );
			
			} // end foreach
			
			wp_update_post( $update_post );
			
		} // end if
		
		/*$fields = $this->service_get_fields();
		
		$parent_post = $this->service_get_parent_post( $fields[ '_cwpp_number' ] ); // TO DO: Update when custom post type created
		
		$update_post = array( 'ID' => $post_id );
		
		if ( $parent_post && $parent_post->ID != $post_id ){
			
			$update_post[ 'post_parent' ] = $parent_post->ID;
			
			foreach( $fields as $key => $value ){
			
				delete_post_meta( $post_id , $key );
				
			} // end foreach
			
		
		} else {
			
			foreach( $fields as $key => $value ){
			
				update_post_meta( $post_id , $key , $value );
				
			} // end foreach
			
			$update_post[ 'post_name' ] = strtolower ( $fields[ '_cwpp_number' ] );
			
		}
		
		wp_update_post( $update_post );*/
		
	}
	
}