<?php
namespace Rnr\Tests\Swedbank;

abstract class RequestsTestCase extends TestCase
{
    protected $password;
    protected $clientId;
    protected $url;

    protected function setUp()
    {
        parent::setUp();

        $this->url = getenv('URL') ?: 'http://example.com';
        $this->clientId = getenv('CLIENT_ID') ?: 'test';
        $this->password = getenv('PASSWORD') ?: 'test';
    }
}