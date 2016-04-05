<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Requests\Request;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;
use DateTime;

class AuthorizationResponseWithout3DResponse extends AuthorizationResponse
{
    private $cardScheme;
    private $country;
    private $token;

    private $acquirer;
    private $transaction;
    private $information;
    /** @var MerchantReference  */
    private $reference;
    private $merchantId;
    private $responseTime;

    public function __construct(SimpleXMLElement $xml, Request $request)
    {
        parent::__construct($xml, $request);

        $this->cardScheme = (string)$xml->CardTxn->card_scheme;
        $this->country = (string)$xml->CardTxn->county;
        $this->token = (string)$xml->CardTxn->token;
        $this->acquirer = (string)$xml->acquirer;
        $this->transaction = (string)$xml->datacash_reference;
        $this->information = (string)$xml->information;
        $this->reference = MerchantReference::createFromString((string)$xml->merchantreference);
        $this->merchantId = (string)$xml->mid;
        $this->responseTime = new DateTime("@{$xml->time}");
    }


}