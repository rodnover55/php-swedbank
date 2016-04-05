<?php
namespace Rnr\Tests\Swedbank;

use Rnr\Swedbank\Requests\CardCaptureRequest;
use Rnr\Swedbank\Responses\CardCaptureResponse;
use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

class CardCaptureRequestTest extends RequestsTestCase
{
    public function testSend() {
        $request = new CardCaptureRequest($this->url, $this->clientId, $this->password);

        $orderId = uniqid();
        $request
            ->setReturnUrl('http://example.com/return')
            ->setExpiryUrl('http://example.com/expiry')
            ->setAmount(new Amount(150))
            ->setReference(new MerchantReference($orderId));
        
        $response = $request->send();

        $this->assertStringStartsWith('https://', $response->getRoute());
        $this->assertNotEmpty($response->getSessionId());
        $this->assertNotEmpty($response->getTransaction());
        $this->assertEquals("{$orderId}/1", $response->getReference()->getReference());
        $this->assertEquals('ACCEPTED', $response->getReason());
        $this->assertEquals(Status::SUCCESS, $response->getStatus());
    }

    public function testUrl() {
        $xml = new SimpleXMLElement(file_get_contents(__DIR__ . '/card-capture-response.xml'));
        
        $response = new CardCaptureResponse(new CardCaptureRequest($this->url, $this->clientId, $this->password), $xml);

        $route = $response->getRoute();
        $sessionId = $response->getSessionId();
        $this->assertEquals("{$route}?HPS_SessionID={$sessionId}", $response->getUrl());
    }
}