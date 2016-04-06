<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Enums\QueryMethod;
use Rnr\Swedbank\Exceptions\ValidationException;
use SimpleXMLElement;

class HistoricTxnPopulator extends AbstractPopulator
{
    private $transaction;

    /**
     * HistoricTxnPopulator constructor.
     * @param $transaction
     */
    public function __construct($transaction = null)
    {
        $this->transaction = $transaction;
    }


    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('reference', $this->transaction);
        $xml->addChild('method', QueryMethod::QUERY);
    }

    public function check()
    {
        if (empty($this->transaction)) {
            throw new ValidationException('Transaction is empty');
        }
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