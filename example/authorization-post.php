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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>title</title>
</head>
<body OnLoad="document.form.submit();">
<form name="form" id="form" action="https://testserver.datacash.com/acs" method="POST">
    <div>
        <input type="hidden" name="PaReq" value="<?php echo $response->getPareqMessage(); ?>">
        <input type="hidden" name="TermUrl" value="<?php echo $baseUrl; ?>"/>
        <input type="hidden" name="MD" value="<?php uniqid(); ?>"/>
    </div>
    <noscript>
        <div>
            <h3>JavaScript is currently disabled or is not supported by your
                browser.</h3>
            <h4>Please click Submit to continue processing your 3-D Secure
                transaction.</h4>
            <input type="submit" value="Submit">
        </div>
    </noscript>
</form>
</body>
</html>