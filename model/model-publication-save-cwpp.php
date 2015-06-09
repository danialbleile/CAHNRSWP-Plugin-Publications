<?php

require_once 'model-publication-cwpp.php';

class Model_Publication_Save_CWPP extends Model_Publication_CWPP {
	
	public function save_publication( $post_id ){
		
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
		
		$fields = $this->service_get_fields();
		
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
		
		wp_update_post( $update_post );
		
	}
	
}