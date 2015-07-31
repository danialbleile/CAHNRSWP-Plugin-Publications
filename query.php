<?php
require_once 'classes/class-publication-query-cwpp.php';

$query = new Publication_Query_CWPP();

$args = $query->get_query_args();

$results = $query->the_query( $args );

echo json_encode( $results );

