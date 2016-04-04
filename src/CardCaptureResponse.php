<?php
namespace Rnr\Swedbank;

use Rnr\Swedbank\Enums\CardCaptureStatus;
use Rnr\Swedbank\Exceptions\CardCaptureException;
use SimpleXMLElement;
use DateTime;
/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class CardCaptureResponse extends Response
{
    private $url;
    private $sessionId;
    private $transaction;
    private $orderId;
    private $mode;
    private $reason;
    private $status;
    private $dateTime;

    public function __construct(CardCaptureRequest $request, SimpleXMLElement $xml)
    {
        parent::__construct($request);


        $this->validate($xml);

        $this->url = (string)$xml->HpsTxn->hps_url;
        $this->sessionId = (string)$xml->HpsTxn->session_id;
        $this->transaction = (string)$xml->datacash_reference;
        $this->orderId = (string)$xml->merchantreference;
        $this->mode = (string)$xml->mode;
        $this->status = (int)$xml->status;
        $this->reason = (string)$xml->reason;
        $this->dateTime = new DateTime("@{$xml->time}");
    }

    protected function validate(SimpleXMLElement $xml) {
        $e = CardCaptureException::createFromXml($xml, $this->getRequest());
        
        if (!empty($e)) {
            throw $e;
        }
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->url;
    }

    public function getUrl() {
        return "{$this->url}?HPS_SessionID={$this->sessionId}";
    }
    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @return string
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }
}