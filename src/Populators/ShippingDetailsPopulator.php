<?php
namespace Rnr\Swedbank\Populators;

use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class ShippingDetailsPopulator extends DetailsPopulator
{
    public function innerCreateElement(SimpleXMLElement $xml)
    {
        $person = $this->details->getPerson();
        $location = $this->details->getLocation();
        
        $xml->addChild('title', $person->getTitle());
        $xml->addChild('first_name', $person->getFirstName());
        $xml->addChild('surname', $person->getSurname());

        foreach ($this->explodeAddress() as $i => $line) {
            $index = $i + 1;
            $xml->addChild("address_line{$index}", $line);
        }

        $xml->addChild('city', $location->getCity());
        $xml->addChild('zip_code', $location->getZip());
        $xml->addChild('country', $location->getCountry());
    }
}