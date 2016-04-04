<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Responses\CardCaptureResponse;
use Rnr\Swedbank\Enums\PageSet;
use Rnr\Swedbank\Exceptions\CardCaptureException;
use Rnr\Swedbank\Requests\Request;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 * @method CardCaptureResponse send()
 */
class CardCaptureRequest extends Request
{
    const EUR = 'EUR';

    private $orderId;
    private $attempt = 1;
    private $currency = self::EUR;
    private $amount;

    private $returnUrl;
    private $expiryUrl;
    private $goBackUrl;
    private $visibilityOfCardholderName = true;
    private $pageSetId = PageSet::ENG;

    protected function createResponse(SimpleXMLElement $response)
    {
        return new CardCaptureResponse($this, $response);
    }

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $this->createHps($xml);
        $this->createDetails($xml);
    }

    protected function createHps(SimpleXMLElement $xml) {
        $this->checkUrl($this->returnUrl, "ReturnUrl '{$this->returnUrl}' hasn't valid format.");
        $this->checkUrl($this->expiryUrl, "ExpiryUrl '{$this->expiryUrl}' hasn't valid format.");

        $hps = $xml->addChild('HpsTxn');

        $hps->addChild('method', 'setup');

        $hps->addChild('return_url', $this->returnUrl);
        $hps->addChild('expiry_url', $this->expiryUrl);
        $hps->addChild('page_set_id', $this->pageSetId);

        $dynamicData = $hps->addChild('DynamicData');
        $dynamicData->addChild('dyn_data_3', $this->visibilityOfCardholderName ? 'show' : '');
        $dynamicData->addChild('dyn_data_4', $this->goBackUrl);

        return $hps;

    }

    protected function createDetails(SimpleXMLElement $xml) {
        $this->checkAmount($this->amount);
        $this->checkOrderId($this->orderId);

        $details = $xml->addChild('TxnDetails');

        $details->addChild('merchantreference', "{$this->orderId}/{$this->attempt}");


        $amount = $details->addChild('amount', $this->amount);
        $amount->addAttribute('currency', $this->currency);


        return $details;
    }

    protected function checkAmount($amount) {
        if (empty($amount)) {
            throw new CardCaptureException("Value of amount '{$this->amount}' has not valid");
        }
    }

    protected function checkOrderId($amount) {
        if (empty($amount)) {
            throw new CardCaptureException("Value of order '{$this->orderId}' has not valid");
        }
    }

    protected function checkUrl($url, $message = 'Url has not valid format') {
        if (empty($url)) {
            throw new CardCaptureException($message);
        }
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return CardCaptureRequest
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     * @return CardCaptureRequest
     */
    public function setAttempt($attempt)
    {
        $this->attempt = $attempt;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return CardCaptureRequest
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     * @return CardCaptureRequest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     * @return CardCaptureRequest
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiryUrl()
    {
        return $this->expiryUrl;
    }

    /**
     * @param mixed $expiryUrl
     * @return CardCaptureRequest
     */
    public function setExpiryUrl($expiryUrl)
    {
        $this->expiryUrl = $expiryUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoBackUrl()
    {
        return $this->goBackUrl;
    }

    /**
     * @param mixed $goBackUrl
     * @return CardCaptureRequest
     */
    public function setGoBackUrl($goBackUrl)
    {
        $this->goBackUrl = $goBackUrl;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isVisibilityOfCardholderName()
    {
        return $this->visibilityOfCardholderName;
    }

    /**
     * @param boolean $visibilityOfCardholderName
     * @return CardCaptureRequest
     */
    public function setVisibilityOfCardholderName($visibilityOfCardholderName)
    {
        $this->visibilityOfCardholderName = $visibilityOfCardholderName;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageSetId()
    {
        return $this->pageSetId;
    }

    /**
     * @param int $pageSetId
     * @return CardCaptureRequest
     */
    public function setPageSetId($pageSetId)
    {
        $this->pageSetId = $pageSetId;
        return $this;
    }
}