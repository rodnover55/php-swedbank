<?php
namespace Rnr\Swedbank\Support\Populators;

use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Contact;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class PersonDetailsPopulator
{
    /** @var Contact */
    private $contact;

    /**
     * PersonDetailsPopulator constructor.
     * @param Contact $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function createElement(SimpleXMLElement $xml) {
        $xml->addChild('first_name', $this->contact->getFirstName());
        $xml->addChild('surname', $this->contact->getSurname());
        $xml->addChild('telephone', $this->contact->getTelephone());
    }
}