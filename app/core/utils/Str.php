<?php

namespace App\Core\Utils;

class Str
{
    /**
     * Format the url to a pattern
     *
     * @param string $url
     * @return string
     */
    public static function setUrlPattern(string $url): string
    {
        $url = explode('?', $url);
        return preg_replace('/\/$/', '', preg_replace('/^\//', '', trim($url[0])));
    }

    /**
     * Return only numbers
     *
     * @param string $word
     * @return string
     */
    public static function getOnlyNumbers(string $word): string
    {
        return preg_replace('/[^0-9]/', '', $word);
    }
}
