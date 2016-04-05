<?php
namespace Rnr\Swedbank\Responses;

use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\AuthorizationException;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InformationFormatter;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\ThreeDSFieldMissingFormatter;
use Rnr\Swedbank\Requests\Request;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class AuthorizationResponse extends Response
{
    public static function createFromXml(SimpleXMLElement $xml, Request $request)
    {
        $status = (int)$xml->status;
        
        return (in_array($status, [Status::NO_RESULT, Status::STATUS_160,
            Status::STATUS_162, Status::STATUS_187])) ?
            (new AuthorizationResponseWithout3DResponse($xml, $request)) : 
            (new AuthorizationResponseWith3DResponse($xml, $request));
    }

    protected function createException($message, $status)
    {
        return new AuthorizationException($message, $status);
    }

    protected function getFormatters()
    {
        $formatters = parent::getFormatters();

        return $formatters + [
            Status::LUHN_CHECK_FAILS => InformationFormatter::class,
            Status::INVALID_PAYMENT_REFERENCE => InformationFormatter::class,
            Status::THREE_DS_FIELD_MISSING => ThreeDSFieldMissingFormatter::class
        ];
    }
}