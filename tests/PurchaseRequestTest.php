<?php
namespace Rnr\Tests\Swedbank;


use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Enums\TestPageSet;
use Rnr\Swedbank\Requests\PurchaseRequest;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\MerchantReference;

class PurchaseRequestTest extends RequestsTestCase
{
    public function testSend() {
        $request = new PurchaseRequest($this->url, $this->clientId, $this->password);

        $orderId = uniqid();
        $request
            ->setReturnUrl('http://example.com/return')
            ->setExpiryUrl('https://example.com/expiry')
            ->setAmount(new Amount(150))
            ->setReference(new MerchantReference($orderId))
            ->setMerchantUrl('http://example.com')
            ->setDescription('test');

        $response = $request->send();

        $this->assertStringStartsWith('https://', $response->getRoute());
        $this->assertNotEmpty($response->getSessionId());
        $this->assertNotEmpty($response->getTransaction());
        $this->assertEquals("{$orderId}/1", $response->getReference()->getReference());
        $this->assertEquals('ACCEPTED', $response->getReason());
        $this->assertEquals(Status::SUCCESS, $response->getStatus());
    }
}