<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\CardCaptureException;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InformationFormatter;
use Rnr\Swedbank\Requests\CardCaptureRequest;
use Rnr\Swedbank\Responses\Response;
use Rnr\Swedbank\Support\MerchantReference;
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
    private $reference;
    private $mode;
    private $reason;
    private $status;
    private $responseTime;

    public function __construct(CardCaptureRequest $request, SimpleXMLElement $xml)
    {
        parent::__construct($xml, $request);

        $this->url = (string)$xml->HpsTxn->hps_url;
        $this->sessionId = (string)$xml->HpsTxn->session_id;
        $this->transaction = (string)$xml->datacash_reference;
        $this->reference = MerchantReference::createFromString((string)$xml->merchantreference);
        $this->mode = (string)$xml->mode;
        $this->status = (int)$xml->status;
        $this->reason = (string)$xml->reason;
        $this->responseTime = new DateTime("@{$xml->time}");
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
     * @return MerchantReference
     */
    public function getReference()
    {
        return $this->reference;
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
    public function getResponseTime()
    {
        return $this->responseTime;
    }

    protected function createException($message, $status)
    {
        return new CardCaptureException($message, $status);
    }

    protected function getFormatters()
    {
        $formatters = parent::getFormatters();

        return $formatters + [
            Status::INVALID_REFERENCE => InformationFormatter::class
        ];
    }
}