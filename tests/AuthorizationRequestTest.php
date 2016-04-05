<?php
namespace Rnr\Tests\Swedbank;
use Rnr\Swedbank\Requests\AuthorizationRequest;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\MerchantReference;

class AuthorizationRequestTest extends RequestsTestCase
{
    public function testSend() {
        $request = new AuthorizationRequest($this->url, $this->clientId, $this->password);

        $orderId = uniqid();
        $contact = new Contact();
        $contact
            ->setEmail('test@example.com')
            ->setFirstName('Test')
            ->setSurname('TTTT')
            ->setIp('8.8.8.8');

        $request
            ->setReference(new MerchantReference($orderId))
            ->setAmount(new Amount(150))
            ->setPersonalDetail($contact)
            ->setTransaction('3700900013766050')
            ->setMerchantUrl('http://example.com')
            ->setDescription('test');

        $response = $request->send();


        $this->fail();
    }
}