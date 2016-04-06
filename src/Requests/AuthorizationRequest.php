<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Responses\AuthorizationResponse;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\Details;
use Rnr\Swedbank\Support\MerchantReference;
use Rnr\Swedbank\Populators\CardTxnPopulator;
use Rnr\Swedbank\Populators\TxnFullDetailsPopulator;
use SimpleXMLElement;

/**
 * @method AuthorizationResponse send()
 */
class AuthorizationRequest extends Request
{
    /** @var MerchantReference */
    private $reference;

    private $transaction;

    /** @var Amount */
    private $amount;

    /** @var Details */
    private $billingDetails;

    /** @var Details */
    private $shippingDetails;
    
    /** @var Contact */
    private $personalDetail;

    private $merchantUrl;
    private $description;

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $detailsPopulator = new TxnFullDetailsPopulator();

        $detailsPopulator
            ->setReference($this->reference)
            ->setAmount($this->amount)
            ->setBillingDetails($this->billingDetails)
            ->setContact($this->personalDetail)
            ->setMerchantUrl($this->merchantUrl)
            ->setDescription($this->description);
        
        $cardPopulator = new CardTxnPopulator();

        $cardPopulator->setTransaction($this->transaction);

        $detailsPopulator->createElement($xml->addChild('TxnDetails'));
        $cardPopulator->createElement($xml->addChild('CardTxn'));
    }

    protected function createResponse(SimpleXMLElement $response)
    {
        return new AuthorizationResponse($response, $this);
    }

    /**
     * @return MerchantReference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param MerchantReference $reference
     * @return AuthorizationRequest
     */
    public function setReference(MerchantReference $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     * @return AuthorizationRequest
     */
    public function setAmount(Amount $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Details
     */
    public function getBillingDetails()
    {
        return $this->billingDetails;
    }

    /**
     * @param Details $billingDetails
     * @return AuthorizationRequest
     */
    public function setBillingDetails(Details $billingDetails)
    {
        $this->billingDetails = $billingDetails;
        return $this;
    }

    /**
     * @return Details
     */
    public function getShippingDetails()
    {
        return $this->shippingDetails;
    }

    /**
     * @param Details $shippingDetails
     * @return AuthorizationRequest
     */
    public function setShippingDetails(Details $shippingDetails)
    {
        $this->shippingDetails = $shippingDetails;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getPersonalDetail()
    {
        return $this->personalDetail;
    }

    /**
     * @param Contact $personalDetail
     * @return AuthorizationRequest
     */
    public function setPersonalDetail(Contact $personalDetail)
    {
        $this->personalDetail = $personalDetail;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantUrl()
    {
        return $this->merchantUrl;
    }

    /**
     * @param mixed $merchantUrl
     * @return AuthorizationRequest
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->merchantUrl = $merchantUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return AuthorizationRequest
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     * @return AuthorizationRequest
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }
}