<?php

class Publication_Short_PDF_CWPP {
	
	private $pub;
	
	public function __construct( $pub ){
		
		$this->pub = $pub;
		
	}
	
	public function the_pdf(){
		
		
		$html = $this->the_header();
		
		$html .= $this->the_content_footer();
		
		$html .= $this->the_cover_page();
		
		$html .= $this->the_content();
		
		$html .= $this->the_indicia();
		
		$html .= $this->the_footer();
		
		return $html;
		
	}
	
	public function the_header(){
		
		$html = '<!doctype html><html><head>';
		
		$html .= '<meta charset="utf-8">';
			
		$html .= '<title>Untitled Document</title>';
		
		$html = '<style>';
		
		ob_start();
		
		include CWPPDIR . 'templates/core-publication.css';
		
		include CWPPDIR . 'templates/short-publication/short-publication.css';
		
		$html .= ob_get_clean();
		
		$html .= '</style>';
			
		$html .= '</head><body>';
		
		return $html;
		
	}
	
	public function the_footer(){
		
		$html = '</body></html>';
		
		return $html;
		
	}
	
	public function the_cover_page(){
		
		ob_start();
		
		include CWPPDIR . 'templates/short-publication/cover-page.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	}
	
	public function the_content(){
		
		$html = '<div id="content-pages" class="pub-section" >';
		
		$html .= $this->the_content_header();
		
		$html .= '<div class="pub-section-inner">'; 
		
		foreach( $this->pub->pub_chapters as $index => $chapter ){
			
			if ( $index > 0 ){
				
				$html .= '<h2>' . $chapter['title'] . '</h2>';
				
			}  else {
				
				$html .= '<h1>' . $chapter['title'] . '</h1>';
				
			}// end if
			
			$html .= apply_filters( 'the_content' , $chapter['content'] );
			
		} // end foreach
		
		$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_content_header(){
		
		$html = '<script type="text/php">
			if ( isset($pdf) ) {
				$text = "WSU EXTENSION  |  ' . strtoupper( $this->pub->pub_title ) . '"; 
				$font = Font_Metrics::get_font("helvetica", "bold");
				$size = 8;
	
  				$footer = $pdf->open_object();
				
				$width = Font_Metrics::get_text_width($text, $font, $size);

  				$w = ( $pdf->get_width() - $width ) * 0.5;
  				$h = 15;
				
  				$pdf->text($w, $h, $text, $font, $size, array(0.7,0.7,0.7) );

  				$pdf->close_object();

  				$pdf->add_object($footer, "all");
  			}</script>';

		return $html;
		
	}
	
	public function the_content_footer(){
		
		$html = '<script type="text/php">

        if ( isset($pdf) ) {
			
			$h = $pdf->get_height() - 25;

          $font = Font_Metrics::get_font("helvetica", "bold");
          $pdf->page_text(30, $h, "' .strtoupper( $this->pub->pub_number ) . '  |  Page {PAGE_NUM}  |  ext.wsu.edu", $font, 7, array(0.7,0.7,0.7) );

        }
        </script>';

		return $html;
		
	}
	
	public function the_indicia(){
		
		ob_start();
		
		include CWPPDIR . 'templates/inc/publication-indicia.php';
		
		$html = ob_get_clean();
		
		return $html;
		
	}
	
}