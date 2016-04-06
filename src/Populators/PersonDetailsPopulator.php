<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Contact;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class PersonDetailsPopulator extends AbstractPopulator
{
    /** @var Contact */
    private $contact;

    /**
     * PersonDetailsPopulator constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact = null)
    {
        $this->contact = $contact;
    }

    public function innerCreateElement(SimpleXMLElement $xml) {
        $xml->addChild('first_name', $this->contact->getFirstName());
        $xml->addChild('surname', $this->contact->getSurname());
        $xml->addChild('telephone', $this->contact->getTelephone());
    }

    public function check()
    {
        if (empty($this->contact)) {
            throw new ValidationException('Contact is not set');
        }

        if (strlen(implode(' ', [$this->contact->getFirstName(), $this->contact->getSurname()])) > 32) {
            throw new ValidationException('Full name is too long (Should be less than 32');
        }
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     * @return $this
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }
}