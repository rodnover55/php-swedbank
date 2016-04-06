<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Contact;
use SimpleXMLElement;

class RiskDetailsPopulator extends AbstractPopulator
{
    /** @var Contact */
    private $person;

    /**
     * PersonalDetails constructor.
     * @param Contact $person
     */
    public function __construct(Contact $person = null)
    {
        $this->person = $person;
    }

    public function check() {
        if (empty($this->person)) {
            throw new ValidationException('Person is empty.');
        }
        
        if (empty($this->person->getEmail())) {
            throw new ValidationException('Email is empty.');
        }
        
        if (empty($this->person->getIp())) {
            throw new ValidationException('IP is empty');
        }
    }
    
    public function innerCreateElement(SimpleXMLElement $xml) {
        $xml->addChild('email_address', $this->person->getEmail());
        $xml->addChild('ip_address', $this->person->getIp());
    }

    /**
     * @return Contact
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Contact $person
     * @return $this
     */
    public function setPerson(Contact $person)
    {
        $this->person = $person;
        return $this;
    }
}