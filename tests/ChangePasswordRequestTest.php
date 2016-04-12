<?php
namespace Rnr\Tests\Swedbank;


use Rnr\Swedbank\Requests\ChangePasswordRequest;

class ChangePasswordRequestTest extends RequestsTestCase
{
    public function testSend() {
        $request = new ChangePasswordRequest($this->url, $this->clientId, $this->password);
        $request->setPassword('Jk2FJRjZ');

        $response = $request->send();
    }
}