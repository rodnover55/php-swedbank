<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Exceptions\ValidationException;
use SimpleXMLElement;

class CardTxnPopulator extends AbstractPopulator
{
    private $transaction;

    /**
     * CardTxnPopulator constructor.
     * @param $transaction
     */
    public function __construct($transaction = null)
    {
        $this->transaction = $transaction;
    }

    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('method', 'auth');
        $detail = $xml->addChild('card_details', $this->transaction);
        $detail->addAttribute('type', 'from_hps');
    }

    public function check()
    {
        if (empty($this->transaction)) {
            throw new ValidationException('Transaction is empty.');
        }
    }

    /**
     * @return null
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param null $transaction
     * @return $this
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }
}