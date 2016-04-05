<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\CommonFormatter;
use Rnr\Swedbank\Requests\Request;
use SimpleXMLElement;
use Exception;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Response
{
    /** @var Request */
    private $request;

    public function __construct(SimpleXMLElement $xml, Request $request) {
        $this->validate($xml, $request);
        $this->request = $request;
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
    
}