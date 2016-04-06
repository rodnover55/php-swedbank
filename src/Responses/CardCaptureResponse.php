<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\CardCaptureException;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InformationFormatter;
use Rnr\Swedbank\Requests\CardCaptureRequest;
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

    public function __construct(SimpleXMLElement $xml, CardCaptureRequest $request)
    {
        parent::__construct($xml, $request);

        $this->url = (string)$xml->HpsTxn->hps_url;
        $this->sessionId = (string)$xml->HpsTxn->session_id;
        $this->transaction = (string)$xml->datacash_reference;
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