<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_D;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use NibbleTech\ExpectationLexer\Tokens\T_WhitespaceOrTab;
use PHPUnit\Framework\TestCase;

class LexerProgressTest extends TestCase
{
    /**
     * @covers \NibbleTech\ExpectationLexer\LexerResult\LexerProgress::new
     */
    public function test_constructs(): void
    {
        $content       = StringContent::with('test');
        $lexerProgress = LexerProgress::new(
            $content
        );

        self::assertEquals($content, $lexerProgress->getContent());
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\LexerResult\LexerProgress::addFoundToken
     */
    public function test_can_add_found_tokens(): void
    {
        $content       = StringContent::with('abc');
        $lexerProgress = LexerProgress::new(
            $content
        );

        $lexerProgress->addFoundToken(
            T_A::fromLexeme('a')
        );
        $lexerProgress->addFoundToken(
            T_B::fromLexeme('b')
        );
        $lexerProgress->addFoundToken(
            T_C::fromLexeme('c')
        );

        self::assertEquals(
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c')
            ],
            $lexerProgress->getTokens(),
        );

        self::assertEquals(
            3,
            $lexerProgress->getContentCursorPosition()
        );
    }

    /**
     * @covers
     */
    public function test_it_can_bookmark_and_rewind_progress(): void
    {
        $content       = StringContent::with('abcd');
        $lexerProgress = LexerProgress::new(
            $content
        );

        $lexerProgress->addFoundToken(
            T_A::fromLexeme('a')
        );
        $lexerProgress->addFoundToken(
            T_B::fromLexeme('b')
        );

        $bookmarkId = $lexerProgress->bookmark();

        $lexerProgress->addFoundToken(
            T_C::fromLexeme('c')
        );
        $lexerProgress->addFoundToken(
            T_D::fromLexeme('d')
        );

        self::assertEquals(
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c'),
                T_D::fromLexeme('d'),
            ],
            $lexerProgress->getTokens(),
        );

        self::assertEquals(
            4,
            $lexerProgress->getContentCursorPosition()
        );

        $lexerProgress->rewind($bookmarkId);

        self::assertEquals(
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
            ],
            $lexerProgress->getTokens(),
        );

        self::assertEquals(
            2,
            $lexerProgress->getContentCursorPosition()
        );
    }

    /**
     * @covers \NibbleTech\ExpectationLexer\LexerResult\LexerProgress::getTokensWithoutFillerTokens
     */
    public function test_it_gets_tokens_without_filler_tokens(): void
    {
        $content       = StringContent::with('a b c');
        $lexerProgress = LexerProgress::new(
            $content
        );

        $lexerProgress->addFoundToken(
            T_A::fromLexeme('a')
        );
        $lexerProgress->addFoundToken(
            T_WhitespaceOrTab::fromLexeme(' ')
        );
        $lexerProgress->addFoundToken(
            T_B::fromLexeme('b')
        );
        $lexerProgress->addFoundToken(
            T_WhitespaceOrTab::fromLexeme(' ')
        );
        $lexerProgress->addFoundToken(
            T_C::fromLexeme('c')
        );

        self::assertEquals(
            [
                T_A::fromLexeme('a'),
                T_B::fromLexeme('b'),
                T_C::fromLexeme('c')
            ],
            $lexerProgress->getTokensWithoutFillerTokens([
                T_WhitespaceOrTab::token()
            ]),
        );
    }
}