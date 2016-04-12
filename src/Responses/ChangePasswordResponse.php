<?php
namespace Rnr\Swedbank\Responses;


use Rnr\Swedbank\Enums\Status;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\InformationFormatter;
use Rnr\Swedbank\Exceptions\ResponseStatusFormatter\ReasonFormatter;

class ChangePasswordResponse extends Response
{
    protected function getFormatters()
    {
        $formatters = parent::getFormatters();

        return $formatters + [
            Status::SIMILAR_PASSWORD => InformationFormatter::class,
            Status::UNKNOWN_ERROR => ReasonFormatter::class,
            Status::UPDATE_CONFIGURATION_FAILED => ReasonFormatter::class
        ];
    }

}