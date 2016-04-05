<?php
namespace Rnr\Swedbank\Enums;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Status
{
    const SUCCESS = 1;
    const AUTH_ERROR = 10;
    const DUPLICATE_REFERENCE = 20;
    const INVALID_REFERENCE = 22;
    const INVALID_XML = 60;
    const THREE_DS_FIELD_MISSING = 155;
    const NO_RESULT = 159;
    const STATUS_160 = 160;
    const STATUS_162 = 162;
    const STATUS_187 = 187;

    const LUHN_CHECK_FAILS = 281;
    const INVALID_PAYMENT_REFERENCE = 815;
}