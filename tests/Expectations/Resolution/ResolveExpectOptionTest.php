<?php

declare(strict_types=1);

namespace Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ResolveExpectOptionTest extends TestCase
{
    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_ignores_optional_tokens_when_not_found(): void
    {
        $config = ExpectedTokenConfiguration::create();

        $lexerProgress = LexerProgress::new(
            StringContent::with('b')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
            $config,
            Expect::one(T_A::token())->optional()
        );

        self::expectNotToPerformAssertions();
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_ignores_optional_tokens_in_an_order(): void
    {
        $lexerProgress = LexerProgress::new(
            StringContent::with('b')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
            ExpectedTokenConfiguration::create(),
            Expect::order([
                Expect::one(T_A::token())->optional(),
                Expect::one(T_B::token()),
            ])
        );

        $this->assertEquals(
            [
                T_B::fromLexeme('b')
            ],
            $lexerProgress->getTokens()
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_supports_repeating_tokens_with_minimum(): void
    {
        $lexerProgress = LexerProgress::new(
            StringContent::with('bbb')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
            ExpectedTokenConfiguration::create(),
            Expect::one(T_B::token())->repeatsAtLeast(3),
        );

        $this->assertEquals(
            [
                T_B::fromLexeme('b'),
                T_B::fromLexeme('b'),
                T_B::fromLexeme('b'),
            ],
            $lexerProgress->getTokens()
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_throws_when_repeating_token_is_less_than_minimum(): void
    {
        $lexerProgress = LexerProgress::new(
            StringContent::with('b')
        );

        $resolver = new ResolveExpectOption();

        $this->expectException(
            TokenNotFound::class
        );

        $resolver->resolve(
            $lexerProgress,
            ExpectedTokenConfiguration::create(),
            Expect::one(T_B::token())->repeatsAtLeast(3),
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_supports_repeating_tokens_with_maximum(): void
    {
        $lexerProgress = LexerProgress::new(
            StringContent::with('bbb')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
            ExpectedTokenConfiguration::create(),
            Expect::one(T_B::token())->repeatsAtMost(3),
        );

        $this->assertEquals(
            [
                T_B::fromLexeme('b'),
                T_B::fromLexeme('b'),
                T_B::fromLexeme('b'),
            ],
            $lexerProgress->getTokens()
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_throws_when_repeating_token_is_more_than_maximum(): void
    {
        $lexerProgress = LexerProgress::new(
            StringContent::with('bbbb')
        );

        $resolver = new ResolveExpectOption();

        $this->expectException(
            TokenNotFound::class
        );

        $resolver->resolve(
            $lexerProgress,
            ExpectedTokenConfiguration::create(),
            Expect::order([
                Expect::one(T_B::token())->repeatsAtMost(3),
                Expect::one(T_A::token()),
            ]),
        );
    }
}