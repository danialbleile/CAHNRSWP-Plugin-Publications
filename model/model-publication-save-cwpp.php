<?php

require_once 'model-publication-cwpp.php';

class Model_Publication_Save_CWPP extends Model_Publication_CWPP {
	
	
	// Builds
	public function build( $post_id ){
		
		// Set from current
		$this->set_id( $post_id );
		
		// Get the publication number
		$number = $this->service_get_post( '_cwpp_number' );
		
		// Set the number
		if ( NULL !== $number ) $this->set_number( $number );
		
		// Get the parent
		$parent = $this->service_get_parent( $post_id , $this->get_number() );
		
		if ( $parent ){
			
			$this->set_parent_post( $parent );
		
			$this->set_parent_id( $parent->ID );
			
		} // end if
		
		// Is top level page
		if ( ! $parent || $parent->ID == $post_id ){
			
			$subtitle = $this->service_get_post( '_cwpp_subtitle' );
			if ( NULL !== $subtitle ) $this->set_subtitle( $subtitle );
			
			$authors = $this->service_get_post( '_cwpp_authors' , 'array' );
			if ( NULL !== $authors ) $this->set_authors( $authors );
		
			$peer_reviewed = $this->service_get_post( '_cwpp_is_peer_reviewed' , 'bool' );
			if ( NULL !== $peer_reviewed ) $this->set_is_peer_reviewed( $peer_reviewed );
			
			$published_month = $this->service_get_post( '_cwpp_published_month' );
			if ( NULL !== $published_month ) $this->set_published_month( $published_month );
			
			$published_year = $this->service_get_post( '_cwpp_published_year' );
			if ( NULL !== $published_year ) $this->set_published_year( $published_year );
			
			$copyright = $this->service_get_post( '_cwpp_copyright' );
			if ( NULL !== $copyright ) $this->set_copyright( $copyright );
			
			$uses_pesticide = $this->service_get_post( '_cwpp_uses_pesticide' );
			if ( NULL !== $uses_pesticide ) $this->set_uses_pesticide( $uses_pesticide );
			
			// --------------------------------
			
			$fields = $this->get_fields();
			
			foreach( $fields as $field_name => $field_data ){
				
				if ( isset( $_POST[ '_cwpp_' . $field_name ] ) ){
					
					$clean_data = $_POST[ '_cwpp_' . $field_name ]; // To Do: add clean function
					
					$this->set_field( $field_name , $clean_data );
					
				} // end if
				
			} // end foreach
			
		} // end if
		
	}
	
	public function service_get_parent( $post_id ) {
		
		// Get pubication number
		$pub_number = $this->get_number();
		
		// If no number
		if ( ! $pub_number ){
			
			// Set to false
			$parent_post = false;
			
		} else { // Has number
			
			// Use number to get parent wp_post
			$parent_post = get_page_by_path( strtolower( $pub_number ),OBJECT, 'publication');
			
		}
		
		return $parent_post;
		
	}
	
	private function service_get_post( $key , $type = 'text' ){
		
		if ( ! empty( $_POST[ $key ] ) ){
			
			$clean_data = NULL;
			
			$data = $_POST[ $key ];
			
			switch( $type ){
				case 'bool':
					$clean_data = ( $data )? 1 : 0;
					break;
				
				case 'array':
					array_walk_recursive( $data , function( &$value , $key ){ $value = sanitize_text_field( $value ); } );
					$clean_data = $data;
					break;
					
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
				
				//$fields['_cwpp_is_peer_reviewed'] = $this->get_is_peer_reviewed();
				
				//$fields['_cwpp_published_month'] = $this->get_published_month();
				
				//$fields['_cwpp_published_year'] = $this->get_published_year();
				
				//$fields['_cwpp_published_year'] = $this->get_published_year();
				
				//$fields['_cwpp_uses_pesticide'] = $this->get_uses_pesticide();
			
				$update_post['post_name'] = $this->get_number();
				
				$new_fields = $this->get_fields();
			
				foreach( $new_fields as $field_name => $field_data ){
						
					update_post_meta( $post_id , '_cwpp_' . $field_name , $field_data['value'] );
					
				} // end foreach
			
			} // end if
			
			foreach( $fields as $key => $value ){
			
				update_post_meta( $post_id , $key , $value );
			
			} // end foreach
			
			wp_update_post( $update_post );
			
		} // end if
		
	}
	
}