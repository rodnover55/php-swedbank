<?php
namespace Rnr\Swedbank\Support;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class StringTool
{
    public static function explode($string, $length) {
        $words = explode(' ', $string);

        $data = [];

        $index = 0;
        foreach ($words as $word) {
            if (mb_strlen($data[$index] . " {$word}") > $length) {
                $index++;

                if (!array_key_exists($index, $data)) {
                    $data[$index] = '';
                }
            }

            $data[$index] .= " {$word}";
        }

        return $data;
    }
}