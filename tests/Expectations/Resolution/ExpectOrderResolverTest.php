<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\AssertTokens;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_D;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;

class ExpectOrderResolverTest extends TestCase
{
    /**
     * 
     */
    public function test_order_of_expect_ones_resolves(): void
    {
        $expectOption = Expect::order([
            Expect::one(T_A::token()),
            Expect::one(T_B::token()),
            Expect::one(T_C::token()),
            Expect::one(T_D::token()),
            Expect::one(T_C::token()),
            Expect::one(T_B::token()),
            Expect::one(T_A::token()),
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('abcdcba'),
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
                T_C::fromLexeme('c'),
                T_B::fromLexeme('b'),
                T_A::fromLexeme('a'),
            ]
        );
    }

    /**
     * 
     */
    public function test_throws_on_incomplete_order(): void
    {
        $expectOption = Expect::order([
            Expect::one(T_A::token()),
            Expect::one(T_B::token()),
            Expect::one(T_C::token()),
            Expect::one(T_D::token()),
        ]);

        self::expectException(TokenNotFound::class);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('abc'),
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
            ]
        );
    }

    /**
     * 
     */
    public function test_single_level_nested_any_of_resolves(): void
    {
        $expectOption = Expect::order([
            Expect::anyOf([
                Expect::one(T_A::token()),
                Expect::one(T_B::token()),
            ]),
            Expect::one(T_C::token())
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('ac'),
            [
                T_A::fromLexeme('a'),
                T_C::fromLexeme('c'),
            ]
        );

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('bc'),
            [
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
            ]
        );
    }

    /**
     * 
     */
    public function test_double_level_nested_any_of_resolves(): void
    {
        $expectOption = Expect::order([
            Expect::anyOf([
                Expect::anyOf([
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                ]),
                Expect::one(T_C::token()),
            ]),
            Expect::one(T_D::token()),
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('acd'),
            [
                T_A::fromLexeme('a'),
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
            ]
        );

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('bcd'),
            [
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
            ]
        );


        $expectOption = Expect::order([
            Expect::one(T_D::token()),
            Expect::anyOf([
                Expect::anyOf([
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                ]),
                Expect::one(T_C::token()),
            ]),
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('dac'),
            [
                T_D::fromLexeme('d'),
                T_A::fromLexeme('a'),
                T_C::fromLexeme('c'),
            ]
        );

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('dbc'),
            [
                T_D::fromLexeme('d'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
            ]
        );
    }

    /**
     * 
     */
    public function test_nested_orders_resolves(): void
    {
        $expectOption = Expect::order([
            Expect::order([
                Expect::one(T_A::token()),
                Expect::one(T_B::token()),
                Expect::one(T_C::token()),
            ]),
            Expect::order([
                Expect::one(T_D::token()),
                Expect::one(T_B::token()),
                Expect::one(T_C::token()),
            ]),
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('abcdbc'),
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
            ]
        );

        $expectOption = Expect::order([
            Expect::order([
                Expect::one(T_D::token()),
                Expect::one(T_B::token()),
                Expect::one(T_C::token()),
            ]),
            Expect::order([
                Expect::one(T_A::token()),
                Expect::one(T_B::token()),
                Expect::one(T_C::token()),
            ]),
        ]);

        AssertTokens::assertResolved(
            new ExpectOrderResolver(),
            $expectOption,
            StringContent::with('dbcabc'),
            [
                T_D::fromLexeme('d'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
            ]
        );
    }
}
