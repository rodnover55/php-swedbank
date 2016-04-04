<?php
namespace Rnr\Swedbank\Support\Populators;

use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Contact;
use SimpleXMLElement;

class RiskDetailsPopulator
{
    /** @var Contact */
    private $person;

    /**
     * PersonalDetails constructor.
     * @param Contact $person
     */
    public function __construct(Contact $person)
    {
        $this->person = $person;
    }

    public function check() {
        if (empty($this->person->getEmail())) {
            throw new ValidationException('Email is empty');
        }
        
        if (empty($this->person->getIp())) {
            throw new ValidationException('IP is empty');
        }
    }
    
    public function createElement(SimpleXMLElement $xml) {
        $xml->addChild('email_address', $this->person->getEmail());
        $xml->addChild('ip_address', $this->person->getIp());
    }
}