<?php

	$pub_json = array();
	
	$html = '';
	
	$pub_id = sanitize_text_field( $_GET[ 'publication' ] );
	
	if ( ! empty( $pub_id ) ){
		
		require_once CWPPDIR . 'model/model-publication-cwpp.php';
	
		require_once CWPPDIR . 'view/view-publication-public-cwpp.php';
		
		$post = get_page_by_path( strtolower( $pub_id ),OBJECT, 'publication');
		
		if ( $post ){
			
			$publication = new Model_Publication_CWPP();

			$publication->build( $post );

			$publication_view = new View_Publication_Public_CWPP( $publication );
			
			$html = '<div id="publication">';
			
			$html .= '<a id="top-marker"></a>';
    	
        	$html .= '<h1 class="publication">' . $publication->get_title() . '</h1>';
    	
        	$html .= $publication_view->the_logo();
    
    		$html .= $publication_view->the_details();
			
			$html .= apply_filters( 'the_content' , $post->post_content );
			
			$html .= $publication_view->the_indicia();

			$html .= '</div>';
			
			$pub_json['content'] = $html;
			
		} // end if
		
	} // end if
	
	echo json_encode( $pub_json );