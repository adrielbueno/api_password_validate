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
}
