<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

class TxnDetailsPopulator extends AbstractPopulator
{
    /** @var AmountPopulator */
    private $amountPopulator;
    /** @var MerchantReferencePopulator */
    private $referencePopulator;

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
}