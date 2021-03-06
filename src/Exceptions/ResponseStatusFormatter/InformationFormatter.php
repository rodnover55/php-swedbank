<?php
namespace Rnr\Swedbank\Exceptions\ResponseStatusFormatter;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class InformationFormatter extends CommonFormatter
{
    public function __toString()
    {
        return "{$this->xml->information}: {$this->xml->reason}";
    }
}