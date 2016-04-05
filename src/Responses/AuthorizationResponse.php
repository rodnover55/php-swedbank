<?php
namespace Rnr\Swedbank\Responses;

use DateTime;
use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\AuthorizationException;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InformationFormatter;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\ThreeDSFieldMissingFormatter;
use Rnr\Swedbank\Requests\Request;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class AuthorizationResponse extends Response
{
    /** @var MerchantReference  */
    private $reference;
    private $country;
    private $cardScheme;
    private $merchantId;
    private $responseTime;
    private $information;
    private $acquirer;
    private $transaction;
    private $token;
    
    private $url;
    private $pareqMessage;
    private $status;

    public function __construct(SimpleXMLElement $xml, Request $request)
    {
        parent::__construct($xml, $request);

        $cardTxn = $xml->CardTxn;

        $this->cardScheme = (string)$cardTxn->card_scheme;
        $this->country = (string)$cardTxn->country;
        $this->token = (string)$cardTxn->token;
        $this->acquirer = (string)$xml->acquirer;
        $this->transaction = (string)$xml->datacash_reference;
        $this->information = (string)$xml->information;
        $this->reference = MerchantReference::createFromString((string)$xml->merchantreference);
        $this->merchantId = (string)$xml->mid;
        $this->responseTime = new DateTime("@{$xml->time}");
        $this->status = (int)$xml->status;
        
        if (isset($cardTxn->ThreeDSecure)) {
            $this->url = (string)$cardTxn->ThreeDSecure->acs_url;
            $this->pareqMessage = (string)$cardTxn->ThreeDSecure->pareq_message;
        }
    }

    protected function createException($message, $status)
    {
        return new AuthorizationException($message, $status);
    }

    protected function getFormatters()
    {
        $formatters = parent::getFormatters();

        return $formatters + [
            Status::LUHN_CHECK_FAILS => InformationFormatter::class,
            Status::INVALID_PAYMENT_REFERENCE => InformationFormatter::class,
            Status::THREE_DS_FIELD_MISSING => ThreeDSFieldMissingFormatter::class
        ];
    }

    /**
     * @return MerchantReference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getCardScheme()
    {
        return $this->cardScheme;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return DateTime
     */
    public function getResponseTime()
    {
        return $this->responseTime;
    }

    /**
     * @return string
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * @return string
     */
    public function getAcquirer()
    {
        return $this->acquirer;
    }

    /**
     * @return string
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getPareqMessage()
    {
        return $this->pareqMessage;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}