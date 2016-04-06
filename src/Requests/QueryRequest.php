<?php
namespace Rnr\Swedbank\Requests;


use Rnr\Swedbank\Populators\HistoricTxnPopulator;
use Rnr\Swedbank\Responses\QueryResponse;
use SimpleXMLElement;

/**
 * @method QueryResponse send()
 */
class QueryRequest extends Request
{
    private $transaction;

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $historyPopulator = new HistoricTxnPopulator($this->transaction);

        $historyPopulator->createElement($xml->addChild('HistoricTxn'));
    }

    protected function createResponse(SimpleXMLElement $response)
    {
        return new QueryResponse($response, $this);
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param mixed $transaction
     * @return $this
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }


}