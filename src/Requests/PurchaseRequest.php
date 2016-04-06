<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Enums\CaptureMethod;
use Rnr\Swedbank\Enums\SetupMethod;
use Rnr\Swedbank\Populators\HpsTxnPopulator;
use Rnr\Swedbank\Populators\TxnDetailsWithoutRiskPopulator;
use Rnr\Swedbank\Responses\PurchaseResponse;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class PurchaseRequest extends CardCaptureRequest
{
    private $errorUrl;
    private $merchantUrl;
    private $description;

    protected function createResponse(SimpleXMLElement $response)
    {
        return new PurchaseResponse($response, $this);
    }

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $hpsPopulator = new HpsTxnPopulator();

        $hpsPopulator
            ->setReturnUrl($this->getReturnUrl())
            ->setExpiryUrl($this->getExpiryUrl())
            ->setErrorUrl($this->errorUrl)
            ->setPageSetId($this->getPageSetId())
            ->setMethod(SetupMethod::FULL);

        $detailsPopulator = new TxnDetailsWithoutRiskPopulator();

        $detailsPopulator
            ->setReference($this->getReference())
            ->setAmount($this->getAmount())
            ->setCaptureMethod(CaptureMethod::ECOMM)
            ->setMerchantUrl($this->merchantUrl)
            ->setDescription($this->description);
        
        $hpsPopulator->createElement($xml->addChild('HpsTxn'));
        $detailsPopulator->createElement($xml->addChild('TxnDetails'));
        
        $cardTxn = $xml->addChild('CardTxn');
        $cardTxn->addChild('method', 'auth');
    }

    /**
     * @return mixed
     */
    public function getErrorUrl()
    {
        return $this->errorUrl;
    }

    /**
     * @param mixed $errorUrl
     * @return $this
     */
    public function setErrorUrl($errorUrl)
    {
        $this->errorUrl = $errorUrl;
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
     * @return $this
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
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}