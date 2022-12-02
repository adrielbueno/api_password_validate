<?php

namespace App\Core\Handlers\Response;

class ResponseHandler
{
    /**
     * Displays a message in json format dealing with the Content-Type 
     * and status code of the request header
     *
     * @param int $httpCode
     * @param array $payload information that may be needed in the response
     *
     * @return void
     */
    public static function printJson(int $httpCode = 200, array $payload = []): void
    {
        header('Content-Type: application/json', true, $httpCode);
        echo json_encode($payload);
        exit;
    }

    /**
     * Return a json dealing with the Content-Type 
     * and status code of the request header
     *
     * @param int $httpCode
     * @param array $payload information that may be needed in the response
     *
     * @return string
     */
    public static function getJson(int $httpCode = 200, array $payload = []): string
    {
        header('Content-Type: application/json', true, $httpCode);
        return json_encode($payload);
    }
}
