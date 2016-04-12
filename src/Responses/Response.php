<?php
namespace Rnr\Swedbank\Responses;

use DateTime;
use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\CommonFormatter;
use Rnr\Swedbank\Requests\Request;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;
use Exception;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Response
{
    protected $reference;
    protected $mode;
    protected $reason;
    protected $responseTime;
    protected $status;

    
    /** @var Request */
    private $request;

    public function __construct(SimpleXMLElement $xml, Request $request) {
        $this->validate($xml, $request);
        $this->request = $request;

        $this->reference = MerchantReference::createFromString((string)$xml->merchantreference);
        $this->mode = (string)$xml->mode;
        $this->status = (int)$xml->status;
        $this->reason = (string)$xml->reason;

        if (!empty((string)$xml->time)) {
            $this->responseTime = new DateTime("@{$xml->time}");
        }
        
    }
    
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function validate(SimpleXMLElement $xml, Request $request = null) {
        $status = (int)$xml->status;
        $formatters = $this->getFormatters();

        if (!array_key_exists($status, $formatters)) {
            return null;
        }

        $class = $formatters[$status];
        $message = new $class($xml, $request);

        throw $this->createException((string)$message, $status);
    }

    protected function createException($message, $status) {
        return new Exception($message, $status);
    }

    protected function getFormatters() {
        return [
            Status::INVALID_XML => CommonFormatter::class,
            Status::DUPLICATE_REFERENCE => CommonFormatter::class,
            Status::AUTH_ERROR => CommonFormatter::class,
        ];
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

}