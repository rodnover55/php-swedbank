<?php
namespace Rnr\Swedbank\Support;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class MerchantReference
{
    private $orderId;
    private $attempt;

    /**
     * MerchantReference constructor.
     * @param $orderId
     * @param $attempt
     */
    public function __construct($orderId, $attempt = 1)
    {
        $this->orderId = $orderId;
        $this->attempt = $attempt;
    }
    
    public function getReference() {
        return "{$this->orderId}/{$this->attempt}";
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     * @return MerchantReference
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     * @return MerchantReference
     */
    public function setAttempt($attempt)
    {
        $this->attempt = $attempt;
        return $this;
    }
}