<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectationResolver;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\LexerConfiguration;
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
            $content
        );

        self::assertTokens(
            $lexerResult,
            LexerConfiguration::create(),
            $resolver,
            $expectation,
            $tokens
        );
    }

    public static function assertTokens(
        LexerProgress $lexerProgress,
        LexerConfiguration $config,
        ExpectationResolver $resolver,
        Expectation $expectation,
        array $tokens
    ): void {
        $resolver->resolve(
            $lexerProgress,
            $config,
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
