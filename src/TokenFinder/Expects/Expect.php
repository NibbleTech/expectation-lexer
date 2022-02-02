<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use NibbleTech\ExpectationLexer\Tokens\Token;

/**
 * Helper static factory of various ExpectOption types
 */
class Expect
{
    final private function __construct()
    {
    }

    public static function one(Token $token): ExpectOne
    {
        return ExpectOne::of($token);
    }

    /**
     * @param ExpectOption[] $expectOptions
     */
    public static function anyOf(array $expectOptions): ExpectAny
    {
        return ExpectAny::of(
            $expectOptions
        );
    }

    /**
     * @param ExpectOption[] $expects
     */
    public static function order(array $expects): ExpectOrder
    {
        return ExpectOrder::with($expects);
    }
}
