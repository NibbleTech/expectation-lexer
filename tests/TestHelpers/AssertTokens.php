<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectationResolver;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;
use NibbleTech\ExpectationLexer\Tokens\Token;
use PHPUnit\Framework\TestCase;

class AssertTokens
{
    /**
     * @param ExpectOption $expectOption
     * @param Token[]      $tokens
     */
    public static function assertResolved(
        ExpectationResolver $resolver,
        ExpectOption $expectOption,
        StringContent $content,
        array $tokens
    ): void {
        $lexerResult = LexerProgress::new(
            $content
        );

        $resolver->resolve(
            $lexerResult,
            $expectOption,
            $content
        );

        TestCase::assertEquals(
            count($tokens),
            count($lexerResult->getTokens())
        );
        TestCase::assertEquals(
            $tokens,
            $lexerResult->getTokens()
        );
    }
}
