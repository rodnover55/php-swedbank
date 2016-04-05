<?php

use Rnr\Swedbank\Requests\CardCaptureRequest;
use Rnr\Swedbank\Enums\TestPageSet;
use Rnr\Swedbank\Support\MerchantReference;
use Rnr\Swedbank\Support\Amount;

require 'bootstrap.php';

$request = new CardCaptureRequest(
    getenv('URL'),
    getenv('CLIENT_ID'),
    getenv('PASSWORD')
);

$baseUrl = "http://{$_SERVER['HTTP_HOST']}";

$reference = new MerchantReference($_REQUEST['orderId']);

$request
    ->setReturnUrl("{$baseUrl}/authorization.php")
    ->setExpiryUrl("{$baseUrl}/card-capture.php")
    ->setAmount(new Amount($_REQUEST['amount']))
    ->setReference(new MerchantReference($_REQUEST['orderId']))
    ->setGoBackUrl("{$baseUrl}/card-capture.php")
    ->setPageSetId(TestPageSet::ENG);

$response = $request->send();

session_id($response->getTransaction());
session_start();

$_SESSION['amount'] = $_REQUEST['amount'];
$_SESSION['orderId'] = $_REQUEST['orderId'];

session_write_close();

header('Status: 302');
header('Location: ' . str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $response->getUrl()));
