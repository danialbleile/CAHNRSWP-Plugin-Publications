( function( document, window ) { 

	if ( typeof jQuery != 'undefined' ) {
		
		var cwpp_init = function(){
			
			this.pub = jQuery('#cwpp-publication');
			
			this.tabs = this.pub.find('#cwpp-publication-nav a');
			
			this.forms = this.pub.find('fieldset');
			
			this.add_author = this.pub.find('.add-author-action');
		
			var s = this;
			
			
			s.activate_tabs = function(){
				
				s.tabs.on( 'click' , function( event ){
					
					event.preventDefault();
					
					var index = jQuery( this ).index();
					
					jQuery( this ).addClass('active').siblings().removeClass('active');
					
					s.forms.eq( index ).addClass('active').siblings('fieldset').removeClass('active');
					
				});
			}
			
			s.authors = function(){
				
				s.add_author.on( 'click', function( event ){
					
					event.preventDefault();
					
					var index = jQuery( this ).siblings('.cwpp-author').length;
					
					if ( typeof cwpp_author != 'undefined' ){
						
						var author = cwpp_author.replace( /\[i\]/g , index );
						
						jQuery( this ).before( author );
						
						
					} // end if
					
					
				});
				
			}
			
		}
		
		
		
		jQuery(document).ready( function() { 
		
			var cwpp = new cwpp_init();
			
			cwpp.activate_tabs();
			
			cwpp.authors();
			
		})
		
	} // end if

} )( document, window ); 