<?php
namespace Rnr\Swedbank\Enums;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class CardCaptureStatus
{
    const SUCCESS = 1;
    const AUTH_ERROR = 10;
    const DUPLICATE_REFERENCE = 20;
    const INVALID_REFERENCE = 22;
    const INVALID_XML = 60;
}