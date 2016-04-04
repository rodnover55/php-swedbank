<?php
namespace Rnr\Swedbank\Support;

use Rnr\Swedbank\Enums\Currency;
use Rnr\Swedbank\Exceptions\ValidationException;
use SimpleXMLElement;
use ReflectionClass;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Amount
{
    private $amount;
    private $currency = Currency::EUR;

    /**
     * AmountElement constructor.
     * @param $amount
     * @param string $currency
     */
    public function __construct($amount, $currency = Currency::EUR)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function createElement(SimpleXMLElement $xml) {
        $amount = $xml->addChild('amount', $this->amount);
        $amount->addAttribute('currency', $this->currency);
        
        return $amount;
    }

    public function check() {
        $supportedCurrencies = (new ReflectionClass(Currency::class))->getConstants();

        if (!in_array($this->currency, array_values($supportedCurrencies))) {
            throw new ValidationException("Currency '{$this->currency}' isn't supported");
        }

        if (empty($this->amount)) {
            throw new ValidationException("Value of amount '{$this->amount}' has not valid");
        }
    }
}