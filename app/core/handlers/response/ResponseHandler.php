<?php

namespace App\Core\Handlers\Response;

use App\Core\Handlers\Request\RequestHandler as Request;

class ResponseHandler
{
    /**
     * Exibe uma mensagem em formato json já tratando o Content-Type e o status code do header da requisição
     * @param string $cod Código da mensagem
     * @param int $httpCode
     * @param array $payload informações que possam ser necessárias
     * @return void
     */
    public static function printJson(int $httpCode = 200, array $payload = []): void
    {
        header('Content-Type: application/json', true, $httpCode);
        echo json_encode($payload);
        exit;
    }

    /**
     * @param string $cod
     * @param integer $httpCode
     * @param array $payload
     * @return string
     */
    public static function getJson(int $httpCode = 200, array $payload = []): string
    {
        header('Content-Type: application/json', true, $httpCode);
        return json_encode($payload);
    }

}
