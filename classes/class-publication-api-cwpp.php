<?php
class Publication_API_CWPP {
	
	public $library_query;
	
	public $service;
	
	public $response;
	
	public $callback;
	
	public function __construct( $library_query ){
		
		// Set library_query
		$this->library_query = $library_query;
		
		// Set service type
		$this->service = ( ! empty( $_GET['api'] ) ) ? sanitize_key( $_GET['api'] ) : 'query';
		
		// Set response type
		$this->response = ( ! empty( $_GET['response'] ) ) ? sanitize_key( $_GET['response'] ) : 'json';
		
		// Set callback value
		$this->callback = ( ! empty( $_GET['callback'] ) ) ? sanitize_key( $_GET['callback'] ) : 'library_results' ;
		
	} // end method __construct
	
	
	public function do_service(){
		
		switch( $this->service ){
			
			case 'az':
			case 'query':
				$this->do_query();
				break;

		} // end switch
		
	} // end do_service
	
	
	public function do_query(){
		
		$args = $this->library_query->get_query_args();
		
		if ( 'az' == $this->service ){
			
			$args['posts_per_page'] = -1;
			
		} // end if 
			
		$results = $this->library_query->the_query( $args );
		
		if ( 'az' == $this->service ){
			
			$results = $this->library_query->trim_az( $results , $_GET['az'] );
			
		} // end if
		
		if ( 'jsonp' == $this->response || 'json' == $this->response ){
			
			echo $this->json( $results );
			
		} // end if
		
	} // end do_query
	
	public function json( $results = array() ){
		
		$json_results = json_encode( $results );
		
		if ( 'jsonp' == $this->response ){
			
			// Add callback wrapper
			$json_results = $this->callback . '(' . $json_results . ');';
			
		} // end if
		
		return $json_results;
		
	} // end method json
	
}