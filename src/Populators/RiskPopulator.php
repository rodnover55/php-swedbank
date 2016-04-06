<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Enums\Channel;
use Rnr\Swedbank\Enums\PaymentMethod;
use Rnr\Swedbank\Support\Contact;
use Rnr\Swedbank\Support\Details;
use SimpleXMLElement;

class RiskPopulator extends AbstractPopulator
{
    /** @var PersonDetailsPopulator  */
    private $personalDetailsPopulator;
    /** @var BillingDetailsPopulator */
    private $billingDetailsPopulator;
    
    /** @var ShippingDetailsPopulator  */
    private $shippingDetailsPopulator;
    
    /** @var RiskDetailsPopulator */
    private $detailsPopulator;

    public function __construct()
    {
        $this->billingDetailsPopulator = new BillingDetailsPopulator();
        $this->personalDetailsPopulator = new PersonDetailsPopulator();
        $this->shippingDetailsPopulator = new ShippingDetailsPopulator();
        $this->detailsPopulator = new RiskDetailsPopulator();
    }

    public function innerCreateElement(SimpleXMLElement $xml)
    {
        $action = $xml->addChild('Action');
        // TODO: Pre/post-authorization would be moved to enums
        $action->addAttribute('service', 1);

        $action->addChild('MerchantConfiguration')->addChild('channel', Channel::WEB);

        $details = $action->addChild('CustomerDetails');

        $orderDetails = $details->addChild('OrderDetails');

        if (!empty($this->getBillingDetails())) {
            $this->billingDetailsPopulator->createElement($orderDetails->addChild('BillingDetails'));
        }

        $this->personalDetailsPopulator->createElement($details->addChild('PersonalDetails'));

        if (!empty($this->getShippingDetails())) {
            $this->shippingDetailsPopulator->createElement($details->addChild('ShippingDetails'));
        }
        
        $details->addChild('PaymentDetails')->addChild('payment_method', PaymentMethod::BANK_CARD);
        
        $this->detailsPopulator->createElement($details->addChild('RiskDetails'));
    }
    
    /**
     * @return Details
     */
    public function getBillingDetails()
    {
        return $this->billingDetailsPopulator->getDetails();
    }

    /**
     * @param Details $details
     * @return $this
     */
    public function setBillingDetails(Details $details = null)
    {
        $this->billingDetailsPopulator->setDetails($details);
        
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->personalDetailsPopulator->getContact();
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact(Contact $contact)
    {
        $this->personalDetailsPopulator->setContact($contact);
        $this->detailsPopulator->setPerson($contact);

        return $this;
    }

    /**
     * @return Details
     */
    public function getShippingDetails()
    {
        return $this->shippingDetailsPopulator->getDetails();
    }

    /**
     * @param Details $details
     * @return $this
     */
    public function setShippingDetails(Details $details)
    {
        $this->shippingDetailsPopulator->setDetails($details);

        return $this;
    }
}