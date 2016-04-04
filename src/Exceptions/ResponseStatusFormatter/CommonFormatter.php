<?php
namespace Rnr\Swedbank\Exceptions\ResponseStatusFormatter;

use Rnr\Swedbank\Requests\Request;
use SimpleXMLElement;

class CommonFormatter
{
    protected $xml;
    protected $request;
    
    public function __construct(SimpleXMLElement $xml, Request $request = null) {
        $this->xml = $xml;
        $this->request = $request;
    }
    
    public function __toString()
    {
        $reason = (string)$this->xml->reason;
        $log = (empty($request)) ? '' : "\n{{$this->request->getLastBody()->asXML()}}";
        
        return "{$reason}{$log}";
    }
}