<?php
namespace Rnr\Swedbank\Populators;


use SimpleXMLElement;

class TxnDetailsWithoutRiskPopulator extends TxnDetailsPopulator
{
    /** @var ThreeDSecurePopulator  */
    protected $threeDPopulator;

    public function __construct()
    {
        parent::__construct();

        $this->threeDPopulator = new ThreeDSecurePopulator();
    }

    /**
     * @return mixed
     */
    public function getMerchantUrl()
    {
        return $this->threeDPopulator->getMerchantUrl();
    }

    /**
     * @param mixed $merchantUrl
     * @return $this
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->threeDPopulator->setMerchantUrl($merchantUrl);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->threeDPopulator->getDescription();
    }

    /**
     * @param mixed $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->threeDPopulator->setDescription($description);

        return $this;
    }

    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        parent::innerCreateElement($xml);

        $this->threeDPopulator->createElement($xml->addChild('ThreeDSecure'));
    }
}