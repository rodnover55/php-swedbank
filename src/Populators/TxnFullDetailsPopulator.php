<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Enums\CaptureMethod;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\Details;
use SimpleXMLElement;

class TxnFullDetailsPopulator extends TxnDetailsWithoutRiskPopulator
{

    /** @var RiskPopulator */
    private $riskPopulator;

    public function __construct()
    {
        parent::__construct();

        $this->riskPopulator = new RiskPopulator();
    }


    public function innerCreateElement(SimpleXMLElement $xml)
    {
        parent::__construct();
        
        $xml->addChild('capturemethod', CaptureMethod::ECOMM);

        $this->riskPopulator->createElement($xml->addChild('Risk'));
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
     * @return TxnFullDetailsPopulator
     */
    public function setBillingDetails($details = null)
    {
        $this->riskPopulator->setBillingDetails($details);

        return $this;
    }

    /**
     * @param Contact $contact
     * @return TxnFullDetailsPopulator
     */
    public function setContact(Contact $contact)
    {
        $this->riskPopulator->setContact($contact);

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->riskPopulator->getContact();
    }
}