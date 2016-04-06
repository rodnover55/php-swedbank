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
    private $value;
    private $currency = Currency::EUR;

    /**
     * AmountElement constructor.
     * @param $amount
     * @param string $currency
     */
    public function __construct($amount, $currency = Currency::EUR)
    {
        $this->value = $amount;
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Amount
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Amount
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

}