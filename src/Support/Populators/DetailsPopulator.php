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
abstract class DetailsPopulator
{
    /** @var Details */
    protected $details;

    public function __construct(Details $details)
    {
        $this->details = $details;
    }

    public function check()
    {
        if (count($this->explodeAddress()) > 2) {
            throw new ValidationException("Address is too long size.");
        }
    }

    protected function explodeAddress()
    {
        return StringTool::explode($this->details->getLocation()->getAddress(),
            Config::LENGTH_ADDRESS);
    }
    
    abstract public function createElement(SimpleXMLElement $xml);
}