<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\UnclassifiedToken;
use PHPUnit\Framework\TestCase;

class TokenFinderTest extends TestCase
{
    private TokenFinder $tokenFinder;

    protected function setUp(): void
    {
        $this->tokenFinder = new TokenFinder();
    }


    public function test_it_finds_token(): void
    {
        $token = UnclassifiedToken::withRegex(
            '/a/'
        );

        $lexerProgress = LexerProgress::new(
            StringContent::with('abc')
        );

        $foundToken = $this->tokenFinder->findToken(
            $lexerProgress,
            $token
        );

        $expectedToken = UnclassifiedToken::fromLexeme('a');

        self::assertEquals(
            $expectedToken,
            $foundToken
        );
    }


    public function test_it_throws_when_failed_to_find_token(): void
    {
        $token = UnclassifiedToken::withRegex(
            '/z/'
        );

        self::expectException(TokenNotFound::class);

        $lexerProgress = LexerProgress::new(
            StringContent::with('abc')
        );

        $this->tokenFinder->findToken(
            $lexerProgress,
            $token
        );
    }
}
