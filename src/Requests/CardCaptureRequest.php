<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Populators\HpsTxnPopulator;
use Rnr\Swedbank\Populators\TxnDetailsPopulator;
use Rnr\Swedbank\Responses\CardCaptureResponse;
use Rnr\Swedbank\Enums\PageSet;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

/**
 * @method CardCaptureResponse send()
 */
class CardCaptureRequest extends Request
{
    /** @var MerchantReference */
    private $reference;

    /** @var Amount */
    private $amount;

    private $returnUrl;
    private $expiryUrl;
    private $goBackUrl;
    private $visibilityOfCardholderName = true;
    private $pageSetId = PageSet::ENG;

    protected function createResponse(SimpleXMLElement $response)
    {
        return new CardCaptureResponse($response, $this);
    }

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $hpsPopulator = new HpsTxnPopulator();

        $hpsPopulator
            ->setReturnUrl($this->returnUrl)
            ->setExpiryUrl($this->expiryUrl)
            ->setPageSetId($this->pageSetId);
        
        $detailsPopulator = new TxnDetailsPopulator();

        $detailsPopulator
            ->setReference($this->reference)
            ->setAmount($this->amount);

        $hpsPopulator->createElement($xml->addChild('HpsTxn'));
        $detailsPopulator->createElement($xml->addChild('TxnDetails'));
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
     * @return $this
     */
    public function setAmount(Amount $amount)
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setPageSetId($pageSetId)
    {
        $this->pageSetId = $pageSetId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return $this
     */
    public function setReference(MerchantReference $reference)
    {
        $this->reference = $reference;
        return $this;
    }
}