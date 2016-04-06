<?php

use Rnr\Swedbank\Requests\PurchaseRequest;
use Rnr\Swedbank\Support\MerchantReference;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Enums\TestPageSet;

require '../bootstrap.php';

$request = new PurchaseRequest(
    getenv('URL'),
    getenv('CLIENT_ID'),
    getenv('PASSWORD')
);

$baseUrl = "http://{$_SERVER['HTTP_HOST']}";

$request
    ->setReturnUrl("{$baseUrl}/success.php")
    ->setExpiryUrl("https://{$_SERVER['HTTP_HOST']}")
    ->setAmount(new Amount($_REQUEST['amount']))
    ->setReference(new MerchantReference($_REQUEST['orderId']))
    ->setGoBackUrl("{$baseUrl}")
    ->setPageSetId(TestPageSet::ENG)
    ->setMerchantUrl('http://example.com')
    ->setDescription('test');

$response = $request->send();

session_id($response->getTransaction());
session_start();

$_SESSION['amount'] = $_REQUEST['amount'];
$_SESSION['orderId'] = $_REQUEST['orderId'];

session_write_close();

header('Status: 302');
header('Location: ' . str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $response->getUrl()));
