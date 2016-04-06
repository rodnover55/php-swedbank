<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Enums\CaptureMethod;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\Details;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class TxnFullDetailsPopulator extends TxnDetailsPopulator
{
    /** @var RiskPopulator */
    private $riskPopulator;
    
    /** @var ThreeDSecurePopulator  */
    private $threeDPopulator;

    public function __construct()
    {
        parent::__construct();
        
        $this->riskPopulator = new RiskPopulator();
        $this->threeDPopulator = new ThreeDSecurePopulator();
    }


    public function innerCreateElement(SimpleXMLElement $xml)
    {
        parent::__construct();
        
        $xml->addChild('capturemethod', CaptureMethod::ECOMM);

        $this->riskPopulator->createElement($xml->addChild('Risk'));
        $this->threeDPopulator->createElement($xml->addChild('ThreeDSecure'));
    }

    /**
     * @return Details
     */
    public function getBillingDetails()
    {
        return $this->riskPopulator->getBillingDetails();
    }

    /**
     * @param Details $details
     * @return $this
     */
    public function setBillingDetails($details = null)
    {
        $this->riskPopulator->setBillingDetails($details);

        return $this;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact(Contact $contact) {
        $this->riskPopulator->setContact($contact);
        
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact() {
        return $this->riskPopulator->getContact();
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
}