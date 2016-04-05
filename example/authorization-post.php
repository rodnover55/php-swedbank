<?php

use Rnr\Swedbank\Requests\AuthorizationRequest;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\MerchantReference;
use Rnr\Swedbank\Support\Amount;

require 'bootstrap.php';

session_id($_REQUEST['dts_reference']);
session_start();

$request = new AuthorizationRequest(
    getenv('URL'),
    getenv('CLIENT_ID'),
    getenv('PASSWORD')
);

$baseUrl = "http://{$_SERVER['HTTP_HOST']}";
$contact = new Contact();

$contact
    ->setEmail($_REQUEST['email'])
    ->setFirstName($_REQUEST['firstName'])
    ->setSurname($_REQUEST['surname'])
    ->setIp($_SERVER['REMOTE_ADDR']);

$request
    ->setReference(new MerchantReference($_REQUEST['orderId']))
    ->setAmount(new Amount($_REQUEST['amount']))
    ->setPersonalDetail($contact)
    ->setTransaction($_REQUEST['dts_reference'])
    ->setMerchantUrl($baseUrl)
    ->setDescription('test');

$response = $request->send();

var_dump($response);