<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Exceptions;

use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Exception;

class TokenNotFound extends Exception
{
    public static function forToken(
        Token $token,
        StringContent $content
    ): self {
        $message = sprintf(
            'Could not match tokens [%s] at cursor position: %d, next 15 chars are: "%s"',
            $token::class,
            $content->getCursorPosition(),
            substr($content->getLookahead(), 0, 15),
        );

        return new self($message);
    }
}
