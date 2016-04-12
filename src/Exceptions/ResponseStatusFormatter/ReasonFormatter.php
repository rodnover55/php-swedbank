<?php
namespace Rnr\Swedbank\Exceptions\ResponseStatusFormatter;


class ReasonFormatter extends CommonFormatter
{
    public function __toString()
    {
        return (string)$this->xml->reason;
    }
}
