<?php
namespace Rnr\Swedbank\Support;

use ReflectionClass;
use Rnr\Swedbank\Enums\Currency;

class EnumTool
{
    public static function getConstants($class) {
        return (new ReflectionClass($class))->getConstants();
    }
}