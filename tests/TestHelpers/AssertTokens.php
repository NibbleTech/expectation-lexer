<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectationResolver;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;
use NibbleTech\ExpectationLexer\Tokens\Token;
use PHPUnit\Framework\TestCase;

class AssertTokens
{
    /**
     * @param Expectation $expectation
     * @param Token[]      $tokens
     */
    public static function assertResolved(
        ExpectationResolver $resolver,
        Expectation $expectation,
        StringContent $content,
        array $tokens
    ): void {
        $lexerResult = LexerProgress::new(
            ExpectedTokenConfiguration::create(
                Expect::order([
                    $expectation
                ])
            ),
            $content
        );

        self::assertTokens(
            $lexerResult,
            $resolver,
            $expectation,
            $tokens
        );
    }

    public static function assertTokens(
        LexerProgress $lexerProgress,
        ExpectationResolver $resolver,
        Expectation $expectation,
        array $tokens
    ): void {
        $resolver->resolve(
            $lexerProgress,
            $expectation
        );

        TestCase::assertEquals(
            count($tokens),
            count($lexerProgress->getTokens())
        );
        TestCase::assertEquals(
            $tokens,
            $lexerProgress->getTokens()
        );
    }
}
