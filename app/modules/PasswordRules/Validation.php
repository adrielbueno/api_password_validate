<?php

namespace App\Modules\PasswordRules;

use App\Modules\PasswordRules\Expressions;
use App\Modules\PasswordRules\Types;

class Validation
{
    private const DYNAMIC_MAPPING_RULES = [
        Types::MIN_SIZE          => 'validateMinSize',
        Types::MIN_UPPER_CASE    => 'validateMinUpperCase',
        Types::MIN_LOWER_CASE    => 'validateMinLowerCase',
        Types::MIN_DIGIT         => 'validateMinDigit',
        Types::MIN_SPECIAL_CHARS => 'validateMinSpecialChars',
        Types::NO_REPEAT         => 'validateNoRepeted'
    ];

    /**
     * Description
     * aqui
     * @param string $password
     * @param array $rulesList
     * @return array
     */
    public  function validatePasswordWithRules(string $password, array $rulesList): array
    {
        $noMatch = [];
        // teste
        foreach ($rulesList as $rule) {
            $nameRule    = $rule->rule;
            $minimumValue = $rule->value;

            $nameFunction = self::DYNAMIC_MAPPING_RULES[$nameRule];

            if(!$this->$nameFunction($password, $minimumValue))
            {
                array_push($noMatch, $nameRule);
            }            
        }

        return $noMatch;
    }

    /**
     * Validates the minimum number of characters in the word
     *aqui
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinSize(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_SIZE, $minimum);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *aqui
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinUpperCase(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_UPPER_CASE, $minimum);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *aqui
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinLowerCase(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_LOWER_CASE, $minimum);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *aqui
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinDigit(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_DIGIT, $minimum);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *aqui
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinSpecialChars(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_SPECIAL_CHARS, $minimum);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *aqui
     * @param string $password
     * @return bool
     */
    private function validateNoRepeted(string $password): bool
    {
        $rule = Expressions::getExpression(Types::NO_REPEAT);

        return !preg_match($rule, $password);
    }
}
