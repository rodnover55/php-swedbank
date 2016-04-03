<?php
namespace Rnr\Tests\Swedbank;
use Rnr\Swedbank\CardCaptureRequest;
use Rnr\Swedbank\Enums\CardCaptureStatus;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class CardCaptureRequestTest extends TestCase
{
    private $url;
    private $clientId;
    private $password;

    protected function setUp()
    {
        parent::setUp();

        $this->url = getenv('URL') ?: 'http://example.com';
        $this->clientId = getenv('CLIENT_ID') ?: 'test';
        $this->password = getenv('PASSWORD') ?: 'test';
    }

    public function testSend() {
        $request = new CardCaptureRequest($this->url, $this->clientId, $this->password);

        $orderId = uniqid();
        $request
            ->setReturnUrl('http://example.com/return')
            ->setExpiryUrl('http://example.com/expiry')
            ->setAmount(150)
            ->setOrderId($orderId);
        
        $response = $request->send();

        $this->assertStringStartsWith('https://', $response->getRoute());
        $this->assertNotEmpty($response->getSessionId());
        $this->assertNotEmpty($response->getTransaction());
        $this->assertEquals("{$orderId}/1", $response->getOrderId());
        $this->assertEquals('ACCEPTED', $response->getReason());
        $this->assertEquals(CardCaptureStatus::SUCCESS, $response->getStatus());
    }
}