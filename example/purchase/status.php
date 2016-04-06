<?php

use Rnr\Swedbank\Requests\QueryRequest;

require '../bootstrap.php';

$request = new QueryRequest(
    getenv('URL'),
    getenv('CLIENT_ID'),
    getenv('PASSWORD')
);

$request
    ->setTransaction($_REQUEST['dts_reference']);

$response = $request->send();

echo $response->succeed() ? ('Status: OK') : ('Status: failed');