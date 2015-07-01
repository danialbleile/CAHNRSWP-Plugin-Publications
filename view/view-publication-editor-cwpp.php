<?php 

class View_Publication_Editor_CWPP {
	
	private $pub;
	
	private $form_builder;
	
	public function __construct( $publication , $form_builder ){
		
		$this->pub = $publication;
		
		$this->form_builder = $form_builder;
		
	}
	
	public function the_editor(){
		
		$html = '<div id="cwpp-publication">';
		
			$html .= '<input class="cwpp-medium-width-input cwpp-large-input" data-default="Enter Publication Number" type="text" name="_cwpp_number" value="' . $this->pub->get_number()  .'" />';
			
			$html .= '<a class="cwpp-link-button cwpp-standard-button" href="' . $this->pub->get_pdf_link() . '?pub-pdf=true" >View PDF</a>';
			
			if ( ! $this->pub->get_id() || $this->pub->get_parent_id() == $this->pub->get_id() ){
				
				$html .= $this->the_tabs();
			
				$html .= $this->the_basic_info();
				
				$html .= $this->the_publication_info();
				
				$html .= $this->the_author_info();
				
			} else {
				
				$html .= '<a href="' . get_edit_post_link( $this->pub->get_parent_id() ) . '" class="cwpp-standard-button" >Edit Publication Settings</a>';
				
			}
            
			//$html .= '<a class="cwpp-link-button cwpp-standard-button" href="' . $this->pub->get_pdf_section_link() . '" >Section PDF</a>';
		
		$html .= '</div>';
		
		echo $html;
		
	}
	
	private function the_tabs(){
		
		$html = '<nav id="cwpp-publication-nav">';
		
		$tabs = array( 'Basic Info','Publication Info','Authors','Table of Contents');
		
		$active = 'active';
		
		foreach( $tabs as $tab ){
			
			$html .= '<a href="#" class="' . $active .'">' . $tab . '</a>';
			
			$active = '';
			
		}
		
		$html .= '</nav>';
		
		return $html;
		
	}
	
	private function the_basic_info(){
		
		ob_start();
		
		include CWPPDIR . 'inc/editor-section-basic.php';
		
		return ob_get_clean();
		
	}
	
	private function the_author_info(){
		
		$authors = $this->pub->get_authors();
		
		$html = '<fieldset id="cwpp-publication-author-info">';
		
		if ( $authors && is_array( $authors ) ){
			
			foreach( $authors as $index => $author ){
				
				$name = '_cwpp_authors[' . $index . ']';
				
				$html .= $this->service_get_author_input( $name , $author );
				
			} // end foreach
			
		} // end if
		
		$html .= '<script type="text/javascript">var cwpp_author = ' . json_encode( $this->service_get_author_input( '_cwpp_authors[[i]]' ) ) . '</script>';
			
		$html .= '<a href="#" class="add-author-action cwpp-standard-button" style="margin-top: 1rem;">Add Author</a>';
		
		$html .= '</fieldset>';
		
		return $html;
		
	}
	
	private function the_publication_info(){
		
		$html = '<fieldset id="cwpp-publication-info">';
		
			$html .= $this->form_builder->month_year_select( 
				'_cwpp_published' , 
				$this->pub->get_field( 'published_month' ),
				$this->pub->get_field( 'published_year' ), 
				'Published' ); 
		
			$html .= $this->form_builder->month_year_select( 
				'_cwpp_reviewed' , 
				$this->pub->get_field( 'reviewed_month' ),
				$this->pub->get_field( 'reviewed_year' ), 
				'Reviewed' ); 
			
			$html .= $this->form_builder->select( 
				'_cwpp_copyright' ,
				$this->form_builder->utility_get_year_array(),
				$this->pub->get_field( 'copyright' ), 
				'Copyright',
				array(),
				false ); 
			
			$html .= '<br />';
			
			$html .= $this->form_builder->checkbox( 
				'_cwpp_is_peer_reviewed',
				'1',
				$this->pub->get_field( 'is_peer_reviewed' ),
				'Peer Reviewed'
				);
			
			$html .= $this->form_builder->checkbox( 
				'_cwpp_uses_pesticide',
				'1',
				$this->pub->get_field( 'uses_pesticide' ),
				'Pesticide Indicia'
				);
			
			$html .= '<br />';
			
			$html .= $this->form_builder->select( 
				'_cwpp_template' ,
				array( 'short-publication' => 'Short Publication' ),
				$this->pub->get_field( 'template' ), 
				'PDF Template' );
				
		
			/*$html .= '<p class="cwpp-inline-input">';
			
				$html .= '<input type="checkbox" name="_cwpp_is_peer_reviewed" value="1" ' . checked( $this->pub->get_is_peer_reviewed() , 1 , false ) . '/>';
				
				$html .= '<label> Peer Reviewed</label>';
				
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<input type="checkbox" name="_cwpp_uses_pesticide" value="1" ' . checked( $this->pub->get_uses_pesticide() , 1 , false ) . '/>';
				
				$html .= '<label> Pesticide Indicia</label>';
				
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Publish Date: </label>';
				
				$html .= '<select name="_cwpp_published_month">';
				
					$the_month = $dates = $this->pub->get_published_month();
				
					$dates = $this->pub->get_dates();
					
					foreach( $dates as $index => $month ) {
						
						$html .= '<option value="' . $index . '" ' . selected( $the_month , $index , false ) . '>' . $month . '</option>';
						
					} // end foreach
				
				$html .= '</select>';
				
				$html .= '<input type="text" name="_cwpp_published_year" value="' . $this->pub->get_published_year() . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Copyright Year: </label>';
				
				$html .= '<input type="text" name="_cwpp_copyright" value="' . $this->pub->get_copyright() . '" />';
			
			$html .= '</p><br /><p class="cwpp-inline-input">';
			
				$html .= '<label>Template </label>';
				
				$html .= '<select name="_cwpp_template" >';
				
					$html .= '<option value="short-publication" >Short Publication</option>';
					
				$html .= '</select>';
				
			$html .= '</p>'; */
		
		$html .= '</fieldset>';
		
		return $html;
	}
	
	private function service_get_author_input( $name , $author = array() ){
		
		$fname = ( empty( $author['f_name'] ) )? '' : $author['f_name'];
		
		$mname = ( empty( $author['m_name'] ) )? '' : $author['m_name'];
		
		$lname = ( empty( $author['l_name'] ) )? '' : $author['l_name'];
		
		$title = ( empty( $author['title'] ) )? '' : $author['title'];
		
		$aff = ( empty( $author['aff'] ) )? '' : $author['aff'];
		
		$email = ( empty( $author['email'] ) )? '' : $author['email'];
		
		$html .= '<span class="cwpp-author">';
		
			$html .= '<p class="cwpp-inline-input">';
			
				$html .= '<label>First Name (<em>Required</em>)</label><br />';
				
				$html .= '<input type="text" data-default="First Name" name="' . $name . '[f_name]" value="' . $fname . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>M</label><br />';
				
				$html .= '<input style="width:70px" type="text" data-default="M" name="' . $name . '[m_name]" value="' . $mname . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Last Name (<em>Required</em>)</label><br />';
				
				$html .= '<input type="text" data-default="Last Name" name="' . $name . '[l_name]" value="' . $lname . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Title</label><br />';
				
				$html .= '<input type="text" data-default="Title" name="' . $name . '[title]" value="' . $title . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Affiliation</label><br />';
				
				$html .= '<input type="text" data-default="Affiliation" name="' . $name . '[aff]" value="' . $aff . '" />';
			
			$html .= '</p><p class="cwpp-inline-input">';
			
				$html .= '<label>Email (WSU Only)</label><br />';
				
				$html .= '<input type="text" name="' . $name . '[email]" value="' . $email . '" />';
			
			$html .= '</p>';
		
		$html .= '</span>';
		
		return $html;
		
	}
}