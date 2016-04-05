<?php
namespace Rnr\Swedbank\Exceptions\ResponseStatusFormatter;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class ThreeDSFieldMissingFormatter extends CommonFormatter
{
    public function __toString()
    {
        return "{$this->xml->reason}: {$this->xml->information}";
    }
}