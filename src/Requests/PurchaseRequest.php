<?php
namespace Rnr\Swedbank\Requests;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class PurchaseRequest extends Request
{

    protected function fillTransaction(SimpleXMLElement $xml)
    {
    }

    protected function createResponse(SimpleXMLElement $response)
    {
        throw new \Exception("Method createResponse isn't implemented.");
    }
}