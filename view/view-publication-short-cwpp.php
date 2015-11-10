<?php

class View_Publication_Short_CWPP {
	
	private $publication;
	
	private $header;
	
	private $cover_page;
	
	private $footer;
	
	public function __construct( $publication ){
		
		$this->publication = $publication;
		
	}
	
	// Gets
	public function get_header(){ return $this->header; }
	public function get_cover_page(){ return $this->cover_page; }
	public function get_footer(){ return $this->footer; }
	
	// Sets
	public function set_header( $header ){ $this->header = $header; }
	public function set_cover_page( $cover_page ){ $this->cover_page = $cover_page; }
	public function set_footer( $footer ){ $this->footer = $footer; }
	
	// Actions
	public function the_publication(){
		
		// Set Output
		
		$this->set_header( $this->service_build_header() );
		
		$this->set_footer( $this->service_build_footer() );
		
		$this->set_cover_page( $this->service_build_cover_page() );
		
		// Get HTML
		
		$html = $this->get_header();
		
		$html .= $this->get_cover_page();
		
		$html .= $this->get_footer();
			
		return $html;
		
	}
	
	
	public function output( $echo = true ){
		
		// Set Output
		
		$this->set_header( $this->service_build_header() );
		
		$this->set_footer( $this->service_build_footer() );
		
		$this->set_cover_page( $this->service_build_cover_page() );
		
		// Get HTML
		
		$html = $this->get_header();
		
		$html .= $this->get_cover_page();
		
		$html .= $this->get_footer();
		
		if ( $echo ){
			
			echo $html;
			
		} else {
			
			return $html;
		}
		
	}
	
	// Services
	public function service_build_header(){
		
		$html = '<!doctype html><html><head>';
		
		$html .= '<meta charset="utf-8">';
			
		$html .= '<title>Untitled Document</title>';
		
		$html = '<style>';
		
		ob_start();
		
		include CWPPDIR . 'templates/css/core-publication.css';
		
		include CWPPDIR . 'templates/css/short-publication.css';
		
		$html .= ob_get_clean();
		
		$html .= '</style>';
			
		$html .= '</head><body>';
		
		return $html;
	}
	
	public function service_build_footer(){
			
		$html = '</body></html>';
		
		return $html;
	}
	
	public function service_build_cover_page( $is_short = true ){
		
		ob_start();
		
		include CWPPDIR . 'templates/inc/publication-cover-page.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	}

}