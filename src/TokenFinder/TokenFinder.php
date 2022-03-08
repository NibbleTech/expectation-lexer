<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Spatie\Regex\Regex;

interface TokenFinder
{
    public function findToken(
        LexerProgress $lexerProgress,
        Token $token
    ): Token;
}
