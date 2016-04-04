<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Curl;
use Rnr\Swedbank\Responses\Response;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class Request
{
    private $url;
    private $clientId;
    private $password;
    private $lastBody;

    /**
     * @param SimpleXMLElement $xml
     */
    abstract protected function fillTransaction(SimpleXMLElement $xml);
    
    /**
     * @param SimpleXMLElement $response
     * @return Response
     */
    abstract protected function createResponse(SimpleXMLElement $response);

    public function __construct($url, $clientId, $password) {
        $this->url = $url;
        $this->clientId = $clientId;
        $this->password = $password;
    }

    /**
     * @return Response
     */
    public function send() {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Request version="2"/>');

        $this->createAuthentication($xml);
        $this->createTransaction($xml);

        $curl = $this->createCurl();
        $curl->setOptions([
            CURLOPT_HTTPHEADER => ['Content-Type: text/xml']
        ]);

        $this->lastBody = $xml;
        $curl->post($this->url, $this->lastBody->asXML());

        return $this->createResponse(new SimpleXMLElement($curl->response));
    }

    protected function createCurl() {
        return new Curl();
    }

    protected function createAuthentication(SimpleXMLElement $xml)
    {
        $authentication = $xml->addChild('Authentication');

        $authentication->addChild('client', $this->clientId);
        $authentication->addChild('password', $this->password);

        return $authentication;
    }

    /**
     * @param $xml
     * @return SimpleXMLElement
     */
    protected function createTransaction(SimpleXMLElement $xml) {
        $transaction = $xml->addChild('Transaction');
        
        $this->fillTransaction($transaction);
        
        return $transaction;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Request
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     * @return Request
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Request
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return SimpleXMLElement
     */
    public function getLastBody()
    {
        return $this->lastBody;
    }
}