<?php
namespace Rnr\Swedbank\Exceptions;

use Exception;
use Rnr\Swedbank\Enums\CardCaptureStatus;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\CommonFormatter;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InvalidReferenceFormatter;
use Rnr\Swedbank\Requests\Request;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class CardCaptureException extends Exception {
    const FORMATTERS = [
        CardCaptureStatus::INVALID_XML => CommonFormatter::class,
        CardCaptureStatus::DUPLICATE_REFERENCE => CommonFormatter::class,
        CardCaptureStatus::AUTH_ERROR => CommonFormatter::class,
        CardCaptureStatus::INVALID_REFERENCE => InvalidReferenceFormatter::class
    ];

    public static function createFromXml(SimpleXMLElement $xml, Request $request = null) {
        $status = (int)$xml->status;

        if (!array_key_exists($status, self::FORMATTERS)) {
            return null;
        }

        $class = self::FORMATTERS[$status];
        $message = new $class($xml, $request);
        
        return new CardCaptureException((string)$message, $status);
    }
}