<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult\Events;

use NibbleTech\ExpectationLexer\Tokens\Token;

class TokenFound implements LexerEvent
{
    public function __construct(
        private Token $token
    ) {
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
