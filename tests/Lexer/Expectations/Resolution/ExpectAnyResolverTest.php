<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectAnyResolver;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\AssertTokens;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_D;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;

class ExpectAnyResolverTest extends TestCase
{

    private ExpectAnyResolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = new ExpectAnyResolver();
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectAnyResolver::resolve
     */
    public function test_any_of_export_one_resolves()
    {
        $expectOption = Expect::anyOf([
            Expect::one(T_A::token()),
            Expect::one(T_B::token()),
        ]);

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('a'),
            [
                T_A::fromLexeme('a')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('b'),
            [
                T_B::fromLexeme('b')
            ]
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectAnyResolver::resolve
     */
    public function test_nested_any_of_resolves()
    {
        $expectOption = Expect::anyOf([
            Expect::anyOf([
                Expect::one(T_A::token()),
                Expect::one(T_B::token()),
            ]),
            Expect::one(T_C::token())
        ]);

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('a'),
            [
                T_A::fromLexeme('a')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('b'),
            [
                T_B::fromLexeme('b')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('c'),
            [
                T_C::fromLexeme('c')
            ]
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectAnyResolver::resolve
     */
    public function test_double_nested_any_of_resolves()
    {
        $expectOption = Expect::anyOf([
            Expect::anyOf([
                Expect::anyOf([
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                ]),
                Expect::one(T_C::token()),
            ]),
            Expect::one(T_D::token())
        ]);

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('a'),
            [
                T_A::fromLexeme('a')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('b'),
            [
                T_B::fromLexeme('b')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('c'),
            [
                T_C::fromLexeme('c')
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('d'),
            [
                T_D::fromLexeme('d')
            ]
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectAnyResolver::resolve
     */
    public function test_any_of_orders()
    {
        $expectOption = Expect::anyOf([
            Expect::anyOf([
                Expect::order([
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                ]),
                Expect::order([
                    Expect::one(T_C::token()),
                    Expect::one(T_D::token()),
                ]),
            ]),
        ]);

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('ab'),
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
            ]
        );

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('cd'),
            [
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
            ]
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectAnyResolver::resolve
     */
    public function test_any_of_orders_with_similar_beginnings()
    {
        $this->markTestSkipped('Use case not supported yet');

        $expectOption = Expect::anyOf([
            Expect::anyOf([
                Expect::order([
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                ]),
                Expect::order([
                    Expect::one(T_A::token()),
                    Expect::one(T_D::token()),
                ]),
            ]),
        ]);

        AssertTokens::assertResolved(
            $this->resolver,
            $expectOption,
            StringContent::with('ad'),
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('d'),
            ]
        );

    }
}
