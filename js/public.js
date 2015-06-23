// JavaScript Document
jQuery( document ).ready( function( $ ){ 

	// Create the object
	var cwpp = new pub_pages( $ ); 
	
	// Wrap Sections
	cwpp.wrap_sections();
	
	//$( 'body' ).on( 'click' , '#pub-prev, #pub-next, #pub-pager span' , function(){ cwpp.to_top(); } );
	
})

var pub_pages = function( $ ){
	
	var s = this;
	
	s.wrap_sections = function(){
		
		// Get the sections
		var sections = $( '#publication section' );
		
		// Wrap sections
		sections.wrapAll( '<div id="cwpp-publication-slider" ' + s.slide_settings() + ' />');
		
		//Add Pager
		s.add_pager();
		
	} // End wrap_sections
	
	s.slide_settings = function(){
		
		var ss = 'class="cycle-slideshow" '; 
    	ss += 'data-cycle-fx="scrollHorz" ';
    	ss += 'data-cycle-timeout=0 ';
    	ss += 'data-cycle-slides="> section" ';
		ss += 'data-cycle-auto-height="container" '; 
		ss += 'data-cycle-prev="#pub-prev" ';
		ss += 'data-cycle-next="#pub-next" ';
		ss += 'data-cycle-pager="#pub-pager" ';
		ss += 'data-cycle-allow-wrap="false" ';
		
		return ss;
		
	} // End slide_settings
	
	s.add_pager = function(){
		
		var html = '<footer id="pub-footer">';
		
		html += '<a href="#top" id="pub-prev">Previous Page</a>';
		
		html += '<div id="pub-pager"></div>';
		
		html += '<a href="#top" id="pub-next">Next Page</a>';
		
		html += '</footer>';
		
		$( '#cwpp-publication-slider' ).after( html );
		
		
	}
	
	s.to_top = function(){
		
		var top = $('#top-marker').offset().top ;
		
		top = top - 100;
		
		$("html, body").animate({ scrollTop: top });
		
	}
	
	
}
