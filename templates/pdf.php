<?php

	define( 'ISPDF' , true ); 
	
	global $post;

	require_once CWPPDIR . 'dompdf/dompdf_config.inc.php';
	
	require_once CWPPDIR . 'model/model-publication-cwpp.php';
	
	require_once CWPPDIR . 'model/model-publication-pdf-cwpp.php';
	
	$publication = new Model_Publication_PDF_CWPP();
	
	$publication->build( $post );
	
	switch( $publication->get_template() ) {
		
		default:
			require_once CWPPDIR . 'classes/class-publication-short-pdf-cwpp.php';
			$publication_view = new Publication_Short_PDF_CWPP( $publication );
			break;
		
	} // End switch
	
	$html = $publication_view->the_pdf();
	
	$dompdf = new DOMPDF();
	
	$dompdf->load_html( $html );
	
	$dompdf->render();
	
	$dompdf->stream("publication.pdf", array("Attachment" => 0));
	
?>