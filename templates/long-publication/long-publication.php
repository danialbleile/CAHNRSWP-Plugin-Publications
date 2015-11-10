<?php

global $post;

require_once CWPPDIR . 'dompdf/dompdf_config.inc.php';

/*

require_once CWPPDIR . 'model/model-publication-post-cwpp.php';

require_once CWPPDIR . 'view/view-publication-short-cwpp.php';

require_once CWPPDIR . 'control/control-publication-cwpp.php';

$publication = new Model_Publication_Post_CWPP();

$publication_view = new View_Publication_Short_CWPP( $publication );

$publication_control = new Control_Publication_CWPP( $publication , $publication_view );

$html = $publication_control->get_publication( $post );

*/

require_once CWPPDIR . 'classes/class-publication-cwpp.php';

require_once CWPPDIR . 'classes/class-publication-short-pdf-cwpp.php';

$pub = new Publication_CWPP();

$pub->the_pub( $post );

$pub_pdf = new Publication_Short_Pdf_CWPP( $pub );

$html = $pub_pdf->the_pdf();

$dompdf = new DOMPDF();

//$dompdf->load_html( $html );

//$dompdf->render();

//$dompdf->stream("publication.pdf", array("Attachment" => 0));