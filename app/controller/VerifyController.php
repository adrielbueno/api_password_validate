<?php

namespace App\Controller;

use App\Core\Handlers\Response\ResponseHandler as Response;
use App\Modules\PasswordRules\Validation;

class VerifyController
{
    /**
     * É a principal função do controller. Recebe a palavra e através de outras funções processa  o resultado e retorna.
     *
     * @return string
     */
    public function validatePassword($input): string
    {
        $password  = $input->password;
        $rulesList = $input->rules;

        $validation = new Validation();

        $noMatch = $validation->validatePasswordWithRules($password, $rulesList);       

        $verify = $noMatch ? false : true;

        return Response::getJson(200, ["verify" => $verify, "noMatch" => $noMatch]);
    }
}
