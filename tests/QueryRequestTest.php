<?php
namespace Rnr\Tests\Swedbank;


use Rnr\Swedbank\Requests\QueryRequest;

class QueryRequestTest extends RequestsTestCase
{
    public function testSend() {
        $request = new QueryRequest($this->url, $this->clientId, $this->password);

        $request
            ->setTransaction('3500900013767946');
        
        $response = $request->send();

        $this->assertTrue($response->succeed());
    }
}