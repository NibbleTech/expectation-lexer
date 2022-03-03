<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use NibbleTech\ExpectationLexer\Tokens\Token;

/**
 * Helper static factory of various ExpectOption types
 */
final class Expect
{
    final private function __construct()
    {
    }

    public static function one(Token $token): Expectation
    {
        return new Expectation(
            ExpectOne::of($token)
        );
    }

    /**
     * @param Expectation[] $expectOptions
     */
    public static function anyOf(array $expectOptions): Expectation
    {
        return new Expectation(
            ExpectAny::of(
                $expectOptions
            )
        );
    }

    /**
     * @param Expectation[] $expects
     */
    public static function order(array $expects): Expectation
    {
        return new Expectation(
            ExpectOrder::with($expects)
        );
    }
}
