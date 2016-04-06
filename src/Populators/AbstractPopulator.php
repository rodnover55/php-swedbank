<?php
namespace Rnr\Swedbank\Populators;

use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class AbstractPopulator
{
    abstract protected function innerCreateElement(SimpleXMLElement $xml);

    public function createElement(SimpleXMLElement $xml) {
        $this->check();

        return $this->innerCreateElement($xml);
    }
    
    public function check() {}
}