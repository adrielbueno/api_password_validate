<?php

namespace App\Controller;

use App\Core\Handlers\Response\ResponseHandler as Response;

class VerifyController
{
   

    public function __construct()
    {
        
    }   

    public function teste($json)
    {
        return Response::getJson('S2A3-001', 200, ["response" => "FUNCIONANDO"]);
    }

   
}
