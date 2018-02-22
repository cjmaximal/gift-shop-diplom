<?php

namespace App\Http;

class Helpers
{
    /**
     * Upper case first letter for utf8
     *
     * @param string $str
     *
     * @return string
     */
    public static function ucfirst_utf8(string $str): string
    {
        return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr($str, 1, mb_strlen($str) - 1, 'utf-8');
    }
}