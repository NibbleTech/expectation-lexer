<?php

declare(strict_types=1);

namespace Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;

class ResolveExpectOptionTest extends TestCase
{
    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_ignores_optional_tokens_when_not_found()
    {
        $lexerProgress = LexerProgress::new(
            ExpectedTokenConfiguration::create(
                Expect::order([
                    Expect::one(T_A::token())->optional(),
                    Expect::one(T_B::token()),
                ])
            ),
            StringContent::with('b')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
            Expect::one(T_A::token())->optional()
        );

        self::expectNotToPerformAssertions();
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption::resolve
     */
    public function test_it_ignores_optional_tokens_in_an_order()
    {
        $lexerProgress = LexerProgress::new(
            ExpectedTokenConfiguration::create(
                Expect::order([
                    Expect::one(T_B::token()),
                ])
            ),
            StringContent::with('b')
        );

        $resolver = new ResolveExpectOption();

        $resolver->resolve(
            $lexerProgress,
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
}
