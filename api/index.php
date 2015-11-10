<?php

require_once CWPPDIR . 'classes/class-publication-api-cwpp.php';

require_once CWPPDIR . 'classes/class-publication-query-cwpp.php';

$query = new Publication_Query_CWPP();

$api = new Publication_API_CWPP( $query );

$api->do_service();

die();