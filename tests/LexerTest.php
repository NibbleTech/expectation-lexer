<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer;

use NibbleTech\ExpectationLexer\Exceptions\ContentStillLeftToParse;
use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use NibbleTech\ExpectationLexer\LexerConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{

    /**
     * @covers Lexer::lex
     */
    public function test_it_throws_exception_when_cant_find_expected_token(): void
    {
        $example = StringContent::with("B");

        $config = LexerConfiguration::create();

        $tokenFinder = new Lexer(
            $config,
            new ResolveExpectOption()
        );

        self::expectException(TokenNotFound::class);

        $tokenFinder->lex(

            Expect::order(
                [
                    Expect::one(T_A::token()),
                ]
            ),
            $example
        );
    }

    /**
     * @covers Lexer::lex
     */
    public function test_it_throws_when_still_content_leftover(): void
    {
        $example = StringContent::with("abcd");

        $config = LexerConfiguration::create();

        $tokenFinder = new Lexer(
            $config,
            new ResolveExpectOption()
        );

        self::expectException(ContentStillLeftToParse::class);

        $tokenFinder->lex(
            Expect::order(
                [
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                    Expect::one(T_C::token()),
                ]
            ),
            $example
        );
    }
}
