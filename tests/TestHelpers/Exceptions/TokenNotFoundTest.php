<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\Exceptions;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\Tokens\Token;
use PHPUnit\Framework\TestCase;

class TokenNotFoundTest extends TestCase
{
    public function test_it_has_right_message(): void
    {
        $exception = TokenNotFound::forToken(
            T_A::token(),
            LexerProgress::new(
                StringContent::with("1234567890123456789")
            )
        );

        $this->assertEquals(
            'Could not match tokens [NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A] at cursor position: 0, next 15 chars are: "123456789012345"',
            $exception->getMessage()
        );
    }
}
