<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\TokenFinder;
use NibbleTech\ExpectationLexer\Tokens\Token;
use NibbleTech\ExpectationLexer\Tokens\UnclassifiedToken;
use LucLeroy\Regex\Regex;
use PHPUnit\Framework\TestCase;

class TokenFinderTest extends TestCase
{
    private TokenFinder $tokenFinder;

    private StringContent $medium;

    private Token $token;

    protected function setUp(): void
    {
        $this->tokenFinder = new TokenFinder();
    }

    /**
     * @covers \Lexer\Lexer\TokenFinder\TokenFinder::findToken
     */
    public function test_it_finds_token()
    {
        $token = UnclassifiedToken::withRegex(
            Regex::create()->literal('a')->getRegex()
        );

        $foundToken = $this->tokenFinder->findToken(
            StringContent::with('abc'),
            $token
        );

        $expectedToken = UnclassifiedToken::fromLexeme('a');

        self::assertEquals(
            $expectedToken,
            $foundToken
        );
    }

    /**
     * @covers \Lexer\Lexer\TokenFinder\TokenFinder::findToken
     */
    public function test_it_throws_when_failed_to_find_token()
    {
        $token = UnclassifiedToken::withRegex(
            Regex::create()->literal('z')->getRegex()
        );

        self::expectException(TokenNotFound::class);

        $this->tokenFinder->findToken(
            StringContent::with('abc'),
            $token
        );
    }
}
