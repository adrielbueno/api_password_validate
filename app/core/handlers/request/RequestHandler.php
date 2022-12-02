<?php

namespace App\Core\Handlers\Request;

class RequestHandler
{
    private static ?self $instance = null;

    /**
     * Returns an instance of RequestHandler
     *
     * @return RequestHandler
     */
    public static function getInstance()
    {
        self::$instance = new RequestHandler();
        return self::$instance;
    }

    /**
     * Returns the endpoint of the request
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $_GET['url'];
    }

    /**
     * Returns the method of the request
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns an array with the data received in the request
     *
     * @return array
     */
    public function getData(): array
    {
        return json_decode($this->getJson(), 1) ?? [];
    }

    /**
     * Returns an object with the data received in the request
     *
     * @return object
     */
    public function getObj(): object
    {
        return json_decode($this->getJson()) ?? (object) [];
    }

    /**
     * Returns a json with the data received in the request
     *
     * @return string
     */
    public function getJson(): string
    {
        return @$GLOBALS['json'] ?? '';
    }

    /**
     * Returns header in lower case
     *
     * @return array
     */
    public function getLowerCaseHeader(): array
    {
        $header = apache_request_headers();
        foreach ($header as $key => $h) {
            $header[ucfirst($key)] = $h;
        }
        return $header;
    }

    /**
     * Returns path parameters
     *
     * @param string $url
     * @return array
     */
    public function getPathParams(string $url): array
    {
        $pathParams = [];
        foreach (explode('/', $url) as $key => $value) {
            if (preg_match("/{(.*)}/", $value)) {
                $pathParams[$key] = $value;
            }
        }
        return $pathParams;
    }
}
