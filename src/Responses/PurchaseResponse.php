<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Requests\PurchaseRequest;
use SimpleXMLElement;

class PurchaseResponse extends CardCaptureResponse
{
    public function __construct(SimpleXMLElement $xml, PurchaseRequest $request)
    {
        parent::__construct($xml, $request);
    }

}