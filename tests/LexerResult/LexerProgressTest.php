<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use PHPUnit\Framework\TestCase;

class LexerProgressTest extends TestCase
{
    /**
     * @covers \NibbleTech\ExpectationLexer\LexerResult\LexerProgress::new
     */
    public function test_constructs()
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
    public function test_can_add_found_tokens()
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
            $lexerProgress->getContent()->getCursorPosition()
        );
    }
}
