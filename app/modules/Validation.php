<?php

namespace App\Modules\PasswordRules;

use App\Modules\PasswordRules\Expressions;

class Validation
{
    /**
     * Validates the minimum number of characters in the word
     *
     * @return array
     */
    private function validateMinSize(string $password, int $minimum, array $noMatchValidate): array
    {
        $rule = '/^(?=.{' . $minimum . ',}).*$/';
        if (!preg_match($rule, $password)) {
            array_push($noMatchValidate, 'minSize');
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
        $rule = '/^(?=.{' . $minimum . ',})(?=.*[A-Z]).*$/';
        if (!preg_match($rule, $password)) {
            array_push($noMatchValidate, 'minUppercase');
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
        $rule = '/^(?=.{' . $minimum . ',})(?=.*[a-z]).*$/';
        if (!preg_match($rule, $password)) {
            array_push($noMatchValidate, 'minLowercase');
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
        $rule = '/^(?=.{' . $minimum . ',})(?=.*[0-9]).*$/';
        if (!preg_match($rule, $password)) {
            array_push($noMatchValidate, 'minDigit');
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
        $rule = '/(?=.{' . $minimum . ',})[^\w]/';

        if (!preg_match($rule, $password)) {
            array_push($noMatchValidate, 'minSpecialChars');
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

        if (preg_match($rule, $password)) {
            array_push($noMatchValidate, 'noRepeted');
        }

        return $noMatchValidate;
    }

    /**
     * Validates the minimum number of characters upper case in the word
     *
     * @return string
     */
    private function getExpressionWithMinimum(string $rule, string $minimum): string
    {
        $expression = str_replace("minimum", $minimum, Expressions::getExpression($rule));

        return $expression;
    }


}
