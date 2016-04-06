<?php
namespace Rnr\Swedbank\Responses;


use Rnr\Swedbank\Enums\Reason;
use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Requests\QueryRequest;
use SimpleXMLElement;

class QueryResponse extends Response
{
    protected $succeed;
    
    public function __construct(SimpleXMLElement $xml, QueryRequest $request)
    {
        parent::__construct($xml, $request);
        
        $this->succeed = ($this->status === Status::SUCCESS) && ($this->reason === Reason::ACCEPTED);
    }

    /**
     * @return boolean
     */
    public function succeed()
    {
        return $this->succeed;
    }
}