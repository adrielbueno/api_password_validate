<?php

namespace App\Controller;

use App\Core\Handlers\Response\ResponseHandler as Response;
use App\Modules\PasswordRules\Validation;

class VerifyController
{
    /**
     * Validates the password received in the route
     * @param object $input
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
