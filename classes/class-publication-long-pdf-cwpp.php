<?php

class Publication_Long_PDF_CWPP {
	
	private $pub;
	
	private $p;
	
	private $h = -1;
	
	private $toc = array();
	
	public function __construct( $pub ){
		
		$this->pub = $pub;
		
	}
	
	public function the_pdf(){
		
		$pages = $this->build_content();
		
		$html = $this->the_header();
		
		$html .= $this->the_content_footer();
		
		$html .= $this->the_cover_page();
		
		$html .= $this->the_title_page();
		
		$html .= $this->the_content( $pages );
		
		$html .= $this->the_indicia();
		
		$html .= $this->the_footer();
		
		return $html;
		
	}
	
	public function build_content(){
		
		$html = '';
		
		foreach( $this->pub->get_chapters() as $i => $chapter ){
			
			if ( $i > 0 ){
				
				$html .= '<h2>' . apply_filters( 'the_title' , $chapter->post_title ) . '</h2>';
				
			}  else {
				
				$html .= '<h1>' . apply_filters( 'the_title' , $chapter->post_title ) . '</h1>';
				
			}// end if
			
			$html .= do_shortcode( $chapter->post_content );
			
		} // end foreach
		
		$pages = explode( '<!--pagebreak-->' , $html );
		
		$page_set = array();
		
		foreach( $pages as $p => $page ){
			
			$this->p = $p;
			
			$page_set[] .= preg_replace_callback ( '/<h[2|3].*?>(.*?)<\/h[2|3]>/' , array( $this ,  'set_toc' ) , $page );
			
		} // end foreach
		
		return $page_set;
		
	} // end build_content()
	
	
	public function set_toc( $match ){
		
		if ( strpos( $match[0] , 'h2' ) !== false ){
			
			$id = 'h2_' . $this->p . '_' . rand( 0 , 10000000 );
					
			$this->h++;
			
			$this->toc[$this->h]['h2'] = array( $match[1] , ( $this->p + 3 ) , $id );
			
		} else {
			
			$id = 'h3_' . $this->p . '_' . rand( 0 , 10000000 );
			
			$this->toc[$this->h]['h3'][] = array( $match[1] , ( $this->p + 3 ) , $id );
			
		} // end if
		
		return '<a name="' . $id . '">' . $match[0] . '</a>';
		
	} // d build_toc
	
	public function the_toc(){
		
		$html = '<div id="pub-toc">'; 
		
		$html .= '<h5>Table of Contents</h5>';
		
		$html .= '<table>';
		
		foreach( $this->toc as $header ){ 
		
			
			$html .= '<tr class="toc-head">';
		
				$html .= '<td class="toc-title"><div class="toc-dotted"></div><a href="#' . $header['h2'][2] . '">' . $header['h2'][0] . '</td></a>';
				
				$html .= '<td class="toc-pgn">' . $header['h2'][1] . '</td>';
			
			$html .= '</tr>';
				
			if ( ! empty( $header['h3'] ) ){
				
				
				foreach( $header['h3'] as $subhead ){
		
					  $html .= '<tr class="toc-subhead">';
				  
						  $html .= '<td class="toc-title"><a href="#' . $subhead[2] . '">' . $subhead[0] . '</a></td>';
						  
						  $html .= '<td class="toc-pgn">' . $subhead[1] . '</td>';
					  
					  $html .= '</tr>'; 
					
				} // end foreach
				
			} // end if 
			
		} // end foreach
		
		$html .= '</table></div>';
		
		return $html;
		
	}
	
	
	public function the_header(){
		
		$html = '<!doctype html><html><head>';
		
		$html .= '<meta charset="utf-8">';
			
		$html .= '<title>Untitled Document</title>';
		
		$html = '<style>';
		
		ob_start();
		
		include CWPPDIR . 'templates/core-publication.css';
		
		include CWPPDIR . 'templates/long-publication/style.css';
		
		$html .= ob_get_clean();
		
		$html .= '</style>';
		
		$html .= '<link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:700italic,400,700" rel="stylesheet" type="text/css">';
			
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
	
	public function the_title_page(){
		
		$html .= '<div id="title-page" class="page ' . implode( ' ' , $this->pub->get_topics() ) . '">';
		
			$html .= '<div id="sidebar">';
			
				$html .= $this->the_toc();
			
			$html .= '</div>';
			
			$html .= '<div id="title-content">';
			
				$html .= '<div class="inner-wrapper">';
			
					$html .= '<h1>' . $this->pub->get_title() . '</h1>';
					
					$html .= $this->the_authors();
					
					$html .= '<h2>Abstract</h2>' . $this->the_abstract();
				
				$html .= '</div>';
			
			$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	} // end the_title_page
	
	public function the_abstract(){
		
		$html = '<div id="abstract">';
		
			$html .= $this->pub->get_abstract();
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_content( $pages ){
		
		$html = '<div id="content-pages" class="pub-section" >';
		
		$html .= $this->the_content_header();
		
		$html .= '<div class="pub-section-inner">'; 
		
		foreach( $pages as $page ){
			
			$html .= $page;
			
		} // end foreach
		
		$html .= '</div>';
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_authors(){
		
		$authors = $this->pub->get_authors();
		
		//var_dump( $authors );
		
		//$author_set = array();
		
		$html = '<div id="authors">By<br />';
		
		
		foreach( $authors as $index => $author ){
			
			if ( 0 != $index && ! empty( $author['l_name'] ) ) $html .= ', ';
			
			if ( ! empty( $author['f_name'] ) ){
					
				$html .= '<strong>' . $author['f_name'] . '</strong>';
				
			} // end if
			
			if ( ! empty( $author['m_name'] ) ){
				
				$html .= ' <strong>' . $author['m_name'] . '</strong>';
				
			} // end if
			
			if ( ! empty( $author['l_name'] ) ){
				
				$html .= ' <strong>' . $author['l_name'] . '</strong>';
				
			} // end if
			
			if ( ! empty( $author['title'] ) ){
				
				$html .= ', ' . $author['title'];
				
			} // end if
			
			if ( ! empty( $author['aff'] ) ){
				
				$html .= ', ' . $author['aff'];
				
			} // end if*/
			
		} // end foreach
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	public function the_content_header(){
		
		$html = '<script type="text/php">
			if ( isset($pdf) ) {
				$text = "WSU EXTENSION  |  ' . str_replace( '&#8217;' , '\'' , strtoupper( $this->pub->get_title() ) ) . '"; 
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
          $pdf->page_text(30, $h, "' .strtoupper( $this->pub->get_number() ) . '  |  Page {PAGE_NUM}  |  ext.wsu.edu", $font, 7, array(0.7,0.7,0.7) );

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
	
	/*public function the_toc(){
		
		$content = '';
		
		foreach( $this->pub->get_chapters() as $index => $chapter ){
			
			$content .= do_shortcode( $chapter->post_content );
			
		} // end foreach
		
		$pages = explode( '<!--pagebreak-->' , $content );
		
		$h = -1;
			
		$toc = array();
		
		foreach( $pages as $p => $page ){
			
			$matches = array();
			
			preg_match_all( '/<h[2|3].*?>(.*?)<\/h[2|3]>/' , $page , $matches );
			
			foreach( $matches[0] as $i => $match ){
				
				if ( strpos( $match , 'h2' ) !== false ){
					
					$h++;
					
					$toc[$h]['h2'] = array( $matches[1][$i] , $p , 'h2_' . $p . '_' . rand( 0 , 10000000 ) );
					
				} else {
					
					$toc[$h]['h3'][] = array( $matches[1][$i] , $p , 'h2_' . $p . '_' . rand( 0 , 10000000 ) );
					
				} // end if
				
			} // end foreach
			
		} // end foreach
		
		/*$html = '<ul>';
		
		foreach( $pages as $p => $page ){
			
			$headers = preg_split ( $this->get_toc_regex( 'h2' ) , $page , NULL , PREG_SPLIT_DELIM_CAPTURE );
			
			while( $i < count( $headers ) ){
				
				$html .
				
				$i = $i + 2;
				
			} // end while
			
		} // end foreach
		
		$html .= '</ul>';*/
		
		//var_dump( $toc );
		
		//return $html;
		
		/*$content = '';
		
		foreach( $this->pub->get_chapters() as $index => $chapter ){
			
			$content .= do_shortcode( $chapter->post_content );
			
		} // end foreach
		
		$pages = explode( '<!--pagebreak-->' , $content );
		
		$toc = array();
		
		$c = 0;
		
		foreach( $pages as $p => $page ){
			
			$headers = preg_split ( $this->get_toc_regex( 'h2' ) , $page , NULL , PREG_SPLIT_DELIM_CAPTURE );
			
			if ( $headers ){
				
				foreach( $headers as $i => $header_set ){
					
					if ( ! $i % 2 == 0 ){
					
						$toc[$p][ $c ] = array( 'hdr' => $header_set );
						
						$s_hdrs = preg_split ( $this->get_toc_regex( 'h3' ) , $headers[ $i++ ] , NULL , PREG_SPLIT_DELIM_CAPTURE );
						
						if ( $s_hdrs ){
							
							foreach( $s_hdrs as $s => $s_hdr ){
								
								if ( ! $i % 2 == 0 ){
									
									$toc[$p][ $c ]['subs'][] = array( 'hdr' => $s_hdr );
									
								} // end if
								
							} // end foreach
							
						} // end if
						
						$c++;
						
					} // end if
					
					//var_dump( $header_set );
					
				} // end foreach
				
			} // end if 
			
			
		} // end foreach
		
		var_dump( $toc );
		
		return count( $pages );*/
		
	//}
	
	public function get_toc_regex( $tag ){
		
		return '/<' . $tag . '.*?>(.*?)<\/' . $tag . '>/';
		
	} // end get_toc_regex
	
}