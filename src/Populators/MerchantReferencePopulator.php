<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

class MerchantReferencePopulator extends AbstractPopulator
{
    /** @var MerchantReference */
    private $reference;

    /**
     * MerchantReferencePopulator constructor.
     * @param MerchantReference $reference
     */
    public function __construct(MerchantReference $reference = null)
    {
        $this->reference = $reference;
    }

    public function check()
    {
        if (empty($this->reference)) {
            throw new ValidationException('Reference is empty');
        }

        $orderId = $this->reference->getOrderId();

        if (empty($orderId)) {
            throw new ValidationException("Value of order '{$orderId}' has not valid");
        }
    }

    public function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('merchantreference', $this->reference->getReference());
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
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }
}