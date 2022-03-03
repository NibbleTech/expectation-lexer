<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Exceptions;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Exception;

final class TokenNotFound extends Exception
{
    public static function forToken(
        Token $token,
        LexerProgress $lexerProgress
    ): self {
        $message = sprintf(
            'Could not match tokens [%s] at cursor position: %d, next 15 chars are: "%s"',
            $token::class,
            $lexerProgress->getContentCursorPosition(),
            substr($lexerProgress->getContentLookahead(), 0, 15),
        );

        return new self($message);
    }
}
