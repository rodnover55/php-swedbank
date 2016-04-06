<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Enums\Currency;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Amount;
use Rnr\Swedbank\Support\EnumTool;
use SimpleXMLElement;
use ReflectionClass;

class AmountPopulator extends AbstractPopulator
{
    /** @var Amount */
    private $amount;

    /**
     * AmountPopulator constructor.
     * @param Amount $amount
     */
    public function __construct(Amount $amount = null)
    {
        $this->amount = $amount;
    }

    public function innerCreateElement(SimpleXMLElement $xml)
    {
        $amount = $xml->addChild('amount', $this->amount->getValue());
        $amount->addAttribute('currency', $this->amount->getCurrency());

        return $amount;
    }

    public function check()
    {
        if (empty($this->amount)) {
            throw new ValidationException('Amount is empty');
        }
        
        $supportedCurrencies = EnumTool::getConstants(Currency::class);
        $currency = $this->amount->getCurrency();
        $amount = $this->amount->getValue();

        if (!in_array($currency, array_values($supportedCurrencies))) {
            throw new ValidationException("Currency '{$currency}' isn't supported");
        }

        if (empty($amount)) {
            throw new ValidationException("Value of amount '{$amount}' has not valid");
        }
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
}