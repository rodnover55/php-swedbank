<?php
namespace Rnr\Swedbank\Support\Populators;

use Rnr\Swedbank\Config;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Details;
use Rnr\Swedbank\Support\StringTool;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class BillingDetailsPopulator extends DetailsPopulator
{
    public function createElement(SimpleXMLElement $xml) {
        $xml->addChild('state_province', $this->details->getLocation()->getProvince());
        $xml->addChild('name', $this->details->getPerson()->getFullName());

        foreach ($this->explodeAddress() as $i => $line) {
            $index = $i + 1;
            $xml->addChild("address_line{$index}", $line);
        }

        $xml->addChild('city', $this->details->getLocation()->getCity());
        $xml->addChild('zip_code', $this->details->getLocation()->getZip());
        $xml->addChild('country', $this->details->getLocation()->getCountry());
    }
}