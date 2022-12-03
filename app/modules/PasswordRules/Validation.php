<?php

namespace App\Modules\PasswordRules;

use App\Modules\PasswordRules\Expressions;
use App\Modules\PasswordRules\Types;
use App\Core\Utils\Str;

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
     * Validate the password with a list of rules
     *
     * @param string $password
     * @param array $rulesList
     * @return array
     */
    public function validatePasswordWithRules(string $password, array $rulesList): array
    {
        return array_reduce($rulesList, function ($carry, $rule) use ($password) {
            $nameRule     = $rule->rule;
            $minimumValue = $rule->value;
            $nameFunction = self::DYNAMIC_MAPPING_RULES[$nameRule];

            if (!$this->$nameFunction($password, $minimumValue)) {
                $carry[] = $nameRule;
            }
            return $carry;
        }, []);
    }

    /**
     * Validates the minimum number of characters in the word
     *
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
     *
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinUpperCase(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_UPPER_CASE, $minimum);
        $password = preg_replace('/[^A-Z ]/', '', $password);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of characters lower case in the word
     *
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinLowerCase(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_LOWER_CASE, $minimum);
        $password = preg_replace('/[^a-z ]/', '', $password);

        return preg_match($rule, $password);
    }

    /**
     * Validates the minimum number of digits in the word
     *
     * @param string $password
     * @param int $minimum
     * @return bool
     */
    private function validateMinDigit(string $password, int $minimum): bool
    {
        $rule = Expressions::getExpressionWithMinimum(Types::MIN_DIGIT, $minimum);

        return preg_match($rule, Str::getOnlyNumbers($password));
    }

    /**
     * Validates the minimum number of special characters in the word
     *
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
     * Validates equal letters in sequence in the word
     *
     * @param string $password
     * @return bool
     */
    private function validateNoRepeted(string $password): bool
    {
        $rule = Expressions::getExpression(Types::NO_REPEAT);

        return !preg_match($rule, $password);
    }
}
