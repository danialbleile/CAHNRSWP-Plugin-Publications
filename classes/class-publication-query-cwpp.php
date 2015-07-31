<?php
class Publication_Query_CWPP {
	
	public function get_query_args(){
		
		$args = array( 'post_type' => 'publication' );
		
		$args['meta_query'] = array( 
			array( 
				'key'     => '_thumbnail_id',
       			'compare' => 'EXISTS'
        		),
    		);
			
		// If is search
		if ( ! empty( $_GET['s'] ) ){
			
			$args['s'] = sanitize_text_field( $_GET['s'] );
			
		} // end if
		
		// If posts_per_page is set
		
		if ( ! empty( $_GET['posts_per_page'] ) && is_numeric ( $_GET['posts_per_page'] ) ){
			
			 $args['posts_per_page'] = $_GET['posts_per_page'];
			 
		} else {
			
			$args['posts_per_page'] = -1;
			
		}// end if
		
		if ( ! empty( $_GET['offset'] ) && is_numeric ( $_GET['offset'] ) ){
			
			$args['offset'] = $_GET['offset'];
			
		} // end if
		
		// Handle Named Categories
		if ( ! empty( $_GET['topics'] ) ){
			
			$topics = explode( ',' , sanitize_text_field( $_GET['topics'] ) );
			
			$args['tax_query'] = array( $this->topics_args( $topics ) );
			
		} else if( ! empty( $_GET['topics_parent'] )){
			
			$topics = explode( ',' , sanitize_text_field( $_GET['topics_parent'] ) );
			
			$args['tax_query'] = array( $this->topics_args( $topics ) );
			
		}// end if
		
		return $args;
		
	}
	
	public function the_query( $args ){
		
		$pubs = array();
		
		$the_query = new WP_Query( $args );
		
		$pubs['count'] = $the_query->found_posts;
		
		$upload_dir = wp_upload_dir();
		
		$pubs['results'] = array();

		// The Loop
		if ( $the_query->have_posts() ) {
			
			$i = 0;
			
			$v = 0;
	
			while ( $the_query->have_posts() ) {
				
				$the_query->the_post();
				
				// Get the post image
				$img = $this->get_img_src( $the_query->post->ID );
				
				// Only include ones with images
				if ( $img ){
					
					$pubs['results'][ $i ] = $this->get_item( $the_query , $v );
					
					$i++;
					
					$v++;
					
				} // end if
				
			} // end while
			
		} // end if
		
		/* Restore original Post Data */
		wp_reset_postdata();
		
		return $pubs;
		
	} // end the_query
	
	public function trim_az( $query , $alpha ){
		
		$as = array();
		
		if (  ! empty( $query['results'] ) ){
			
			foreach ( $query['results'] as $index => $result ){
				
				$title = strtolower ( $result['title'] );
				
				if ( $title[0] != $alpha ){
					
					unset( $query['results'][ $index ] );
					
				} // end if
				
			} // end foreach
			
		} // end if
		
		return $query;
		
	} // end the_query
	
	
	
	public function get_item( $query , $v = 0 ){
		
		$pub = array();
		
		$pub['title'] = get_the_title();
				
		$pub['img'] = $this->get_img_src( $query->post->ID );
		
		$pub['link'] = get_permalink();
		
		$pub['pageviews'] = $v;
		
		return $pub;
		
	}
	
	
	public function get_img_src( $post_id ){
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
		
		return $image[0];
		
	}
	
	public function topics_args( $topics ){
		
		$params = array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'topic',
				'field'    => 'slug',
				'terms'    => $topics,
			),
		);
		
		return $params;
		
	}
	
}