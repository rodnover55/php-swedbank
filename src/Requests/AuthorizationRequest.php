<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Enums\CaptureMethod;
use Rnr\Swedbank\Enums\Channel;
use Rnr\Swedbank\Enums\PaymentMethod;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Responses\AuthorizationResponse;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\Details;
use Rnr\Swedbank\Support\MerchantReference;
use Rnr\Swedbank\Support\Populators\BillingDetailsPopulator;
use Rnr\Swedbank\Support\Populators\PersonDetailsPopulator;
use Rnr\Swedbank\Support\Populators\RiskDetailsPopulator;
use Rnr\Swedbank\Support\Populators\ShippingDetailsPopulator;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class AuthorizationRequest extends Request
{
    const METHOD_AUTH = 'auth';

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
        $this->check();
        $this->createDetails($xml);
        $this->createCard($xml);
    }

    protected function check() {
        if (empty($this->reference)) {
            throw new ValidationException('Reference is empty');
        }

        if (empty($this->amount)) {
            throw new ValidationException('Amount is empty');
        }
        
        if (empty($this->merchantUrl)) {
            throw new ValidationException('Merchant url is empty');
        }
    }

    protected function createDetails(SimpleXMLElement $xml) {
        $this->reference->check();
        $this->amount->check();

        $details = $xml->addChild('TxnDetails');

        $details->addChild('merchantreference', $this->reference->getReference());
        $details->addChild('capturemethod', CaptureMethod::ECOMM);

        $this->amount->createElement($details);

        $this->createRisk($details);
        $this->createThreeDSecure($details);

        return $details;
    }

    protected function createRisk(SimpleXMLElement $xml) {
        $action = $xml->addChild('Risk')->addChild('Action');
        // TODO: Pre/post-authorization would be moved to enums
        $action->addAttribute('service', 1);

        $action->addChild('MerchantConfiguration')->addChild('channel', Channel::WEB);
        
        $details = $action->addChild('CustomerDetails');

        $orderDetails = $details->addChild('OrderDetails');
        $this->createBillingDetails($orderDetails);
        
        (new PersonDetailsPopulator($this->personalDetail))
            ->createElement($details->addChild('PersonalDetails'));
        
        $this->createShippingDetails($details);
        $details->addChild('PaymentDetails')->addChild('payment_method', PaymentMethod::BANK_CARD);
        $this->createRiskDetails($details);
    }

    protected function createBillingDetails(SimpleXMLElement $xml) {
        if (!empty($this->billingDetails)) {
            $populator = new BillingDetailsPopulator($this->billingDetails);
            $populator->check();
            $populator->createElement($xml->addChild('BillingDetails'));
        }
    }

    protected function createShippingDetails(SimpleXMLElement $xml) {
        if (!empty($this->shippingDetails)) {
            $populator = new ShippingDetailsPopulator($this->shippingDetails);
            $populator->check();
            $populator->createElement($xml->addChild('ShippingDetails'));
        }
    }

    protected function createRiskDetails(SimpleXMLElement $xml) {
        $populator = new RiskDetailsPopulator($this->personalDetail);
        $populator->check();
        $populator->createElement($xml->addChild('RiskDetails'));
    }

    protected function createThreeDSecure(SimpleXMLElement $xml) {
        $secure = $xml->addChild('ThreeDSecure');
        $secure->addChild('purchase_datetime', date('Ymd h:i:s'));
        // TODO: Discover possible values and system's behavior
        $secure->addChild('verify', 'yes');
        // TODO: Discover possible values
        $secure->addChild('Browser')->addChild('device_category', 0);
        $secure->addChild('merchant_url', $this->merchantUrl);
        $secure->addChild('purchase_desc', $this->description);

    }

    protected function createCard(SimpleXMLElement $xml) {
        $card = $xml->addChild('CardTxn');

        $card->addChild('method', self::METHOD_AUTH);
        $detail = $card->addChild('card_details', $this->transaction);
        $detail->addAttribute('type', 'from_hps');

        return $card;
    }

    protected function createResponse(SimpleXMLElement $response)
    {
        return AuthorizationResponse::createFromXml($response, $this);
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