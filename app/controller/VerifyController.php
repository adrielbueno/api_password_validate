<?php

namespace App\Controller;

use App\Core\Handlers\Response\ResponseHandler as Response;

class VerifyController
{


    public function __construct()
    {
    }

    private const MIN_SIZE = 0;
    private const MIN_UPPER_CASE = 1;
    private const MIN_LOWER_CASE = 2;
    private const MIN_DIGIT = 3;
    private const MIN_SPECIAL_CHARS = 4;

    /**
     * É a principal função do controller. Recebe a palavra e através de outras funções processa  o resultado e retorna.
     *
     * @return string
     */
    public function validatePassword($input): string
    {
        $password   = $input->password;
        $rulesList = self::getRulesInput($input);
        

        $noMatch = [];

       

        $verify = $noMatch ? false : true;

        return Response::getJson('S2A3-001', 200, ["verify" => $verify, "noMatch" => $noMatch]);
    }



    // "rules": [
    //       {"rule": "minSize","value": 3},
    //       {"rule": "minUpperCase","value": 1},
    //       {"rule": "minLowerCase","value": 1},
    //       {"rule": "minDigit","value": 1},
    //       {"rule": "minSpecialChars","value": 18},
    //       {"rule": "noRepeted","value": 0}
    //   ]

    /**
     * Validate the input word
     *aqui
     * @return array
     */
    private function getRulesInput($input): array
    {
        $rulesList = [];

        foreach ($input->rules as $rule) {
            $rulesList += [$rule->rule => $rule->value];
        }

        return $rulesList;
    }
}
