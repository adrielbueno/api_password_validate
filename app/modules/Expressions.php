<?php

namespace App\Modules\PasswordRules;

use App\Modules\PasswordRules\Types;

class Expressions
{
    private const EXPRESSION_MIN_SIZE          = '/^(?=.{minimum,}).*$/';
    private const EXPRESSION_MIN_UPPER_CASE    = '/^(?=.{minimum,})(?=.*[A-Z]).*$/';
    private const EXPRESSION_MIN_LOWER_CASE    = '/^(?=.{minimum,})(?=.*[a-z]).*$/';
    private const EXPRESSION_MIN_DIGIT         = '/^(?=.{minimum,})(?=.*[0-9]).*$/';
    private const EXPRESSION_MIN_SPECIAL_CHARS = '/(?=.{minimum,})[^\w]/';
    private const EXPRESSION_NO_REPEAT         = '/(.)\1+/';

    public static function getExpression(string $rule): string
    {
        return self::getArrayExpresions()[$rule];
    }

    private function getArrayExpresions(): array
    {
        return [
            Types::MIN_SIZE          => self::EXPRESSION_MIN_SIZE,
            Types::MIN_UPPER_CASE    => self::EXPRESSION_MIN_UPPER_CASE,
            Types::MIN_LOWER_CASE    => self::EXPRESSION_MIN_LOWER_CASE,
            Types::MIN_DIGIT         => self::EXPRESSION_MIN_DIGIT,
            Types::MIN_SPECIAL_CHARS => self::EXPRESSION_MIN_SPECIAL_CHARS,
            Types::NO_REPEAT         => self::EXPRESSION_NO_REPEAT,
        ];
    }
}
