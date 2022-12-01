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
		public function validatePassword($json): string
		{
            // self::validateInput();

            $input = $json;

            $password    				 = $input->password;
            $ruleMinSize 				 = $input->rules[self::MIN_SIZE]->value ?? 0;
            $ruleMinUpperCase 	 = $input->rules[self::MIN_UPPER_CASE]->value ?? 0;
            $ruleMinLowerCase    = $input->rules[self::MIN_LOWER_CASE]->value ?? 0;
            $ruleMinDigit 			 = $input->rules[self::MIN_DIGIT]->value ?? 0;
            $ruleMinSpecialChars = $input->rules[self::MIN_SPECIAL_CHARS]->value ?? 0;
            

            $noMatch = [];

            $noMatch = self::validateMinSize($password, $ruleMinSize, $noMatch);
            $noMatch = self::validateMinUpperCase($password, $ruleMinUpperCase, $noMatch);
            $noMatch = self::validateMinLowerCase($password, $ruleMinLowerCase, $noMatch);
            $noMatch = self::validateMinDigit($password, $ruleMinDigit, $noMatch);
            $noMatch = self::validateMinSpecialChars($password, $ruleMinSpecialChars, $noMatch);
            $noMatch = self::validateNoRepeted($password, $noMatch);

            $verify = $noMatch ? false : true;

            return Response::getJson('S2A3-001', 200, ["verify" => $verify, "noMatch" => $noMatch]);
            
		}

		/**
		* Validates the minimum number of characters in the word
		*
		* @return array
		*/
		private function validateMinSize(string $password, int $minimum, array $noMatchValidate): array
		{
            $rule = '/^(?=.{'.$minimum.',}).*$/';
            if (!preg_match($rule, $password)) 
            {
                    array_push($noMatchValidate,'minSize');
            }

            return $noMatchValidate;
		}

		/**
		* Validates the minimum number of characters upper case in the word
		*
		* @return array
		*/
		private function validateMinUpperCase(string $password, int $minimum, array $noMatchValidate): array
		{
				$rule = '/^(?=.{'.$minimum.',})(?=.*[A-Z]).*$/';
				if (!preg_match($rule, $password)) 
				{
						array_push($noMatchValidate,'minUppercase');
				}

				return $noMatchValidate;
		}

		/**
		* Validates the minimum number of characters upper case in the word
		*
		* @return array
		*/
		private function validateMinLowerCase(string $password, int $minimum, array $noMatchValidate): array
		{
				//$rule = '/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/';
				$rule = '/^(?=.{'.$minimum.',})(?=.*[a-z]).*$/';
				if (!preg_match($rule, $password)) 
				{
						array_push($noMatchValidate,'minLowercase');
				}

				return $noMatchValidate;
		}

		/**
		* Validates the minimum number of characters upper case in the word
		*
		* @return array
		*/
		private function validateMinDigit(string $password, int $minimum, array $noMatchValidate): array
		{
				//$rule = '/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/';
				$rule = '/^(?=.{'.$minimum.',})(?=.*[0-9]).*$/';
				if (!preg_match($rule, $password)) 
				{
						array_push($noMatchValidate,'minDigit');
				}

				return $noMatchValidate;
		}

		/**
		* Validates the minimum number of characters upper case in the word
		*
		* @return array
		*/
		private function validateMinSpecialChars(string $password, int $minimum, array $noMatchValidate): array
		{
				$rule = '/(?=.{'.$minimum.',})[^\w]/';
				
				if (!preg_match($rule, $password)) 
				{
						array_push($noMatchValidate,'minSpecialChars');
				}

				return $noMatchValidate;
		}

		/**
		* Validates the minimum number of characters upper case in the word
		*
		* @return array
		*/
		private function validateNoRepeted(string $password, array $noMatchValidate): array
		{
				$rule = '/(.)\1+/';
				
				if (preg_match($rule, $password)) 
				{
						array_push($noMatchValidate,'noRepeted');
				}

				return $noMatchValidate;
		}

		// /**
		// * Validate the input word
		// *
		// * @return void
		// */
		// private function validateInput(): void{
		// 		if (empty($this->getRequestData()->password))
		// 		{
		// 				$this->returnJson(["error" => "Word invalid."], 400);
		// 		}
		// }

   
}
