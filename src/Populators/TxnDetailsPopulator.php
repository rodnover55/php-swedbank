<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Enums\CaptureMethod;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\EnumTool;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

class TxnDetailsPopulator extends AbstractPopulator
{
    /** @var AmountPopulator */
    private $amountPopulator;
    /** @var MerchantReferencePopulator */
    private $referencePopulator;

    private $captureMethod;

    /**
     * TxnDetailsPopulator constructor.
     */
    public function __construct()
    {
        $this->amountPopulator = new AmountPopulator();
        $this->referencePopulator = new MerchantReferencePopulator();
    }

    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $this->referencePopulator->createElement($xml);
        $this->amountPopulator->createElement($xml);

        if (!empty($this->captureMethod)) {
            $xml->addChild('capturemethod', $this->captureMethod);
        }
    }

    public function check()
    {
        parent::check();

        $methods = EnumTool::getConstants(CaptureMethod::class);

        if (!empty($this->captureMethod) && !in_array($this->captureMethod, array_values($methods))) {
            throw new ValidationException("Capture method '{$this->captureMethod}' has invalid value.");
        }
    }

    /**
     * @return MerchantReference
     */
    public function getReference()
    {
        return $this->referencePopulator->getReference();
    }

    /**
     * @param MerchantReference $reference
     * @return TxnFullDetailsPopulator
     */
    public function setReference(MerchantReference $reference)
    {
        $this->referencePopulator->setReference($reference);

        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        $this->amountPopulator->getAmount();
    }

    /**
     * @param Amount $amount
     * @return TxnFullDetailsPopulator
     */
    public function setAmount($amount)
    {
        $this->amountPopulator->setAmount($amount);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaptureMethod()
    {
        return $this->captureMethod;
    }

    /**
     * @param mixed $captureMethod
     * @return $this
     */
    public function setCaptureMethod($captureMethod)
    {
        $this->captureMethod = $captureMethod;
        
        return $this;
    }
}