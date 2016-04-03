<?php
namespace Rnr\Swedbank\Exceptions\ResponseStatusFormatter;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class InvalidReferenceFormatter extends CommonFormatter
{
    public function __toString()
    {
        return (string)$this->xml->information;
    }
}