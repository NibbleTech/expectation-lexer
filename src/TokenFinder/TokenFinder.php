<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Spatie\Regex\Regex;

class TokenFinder
{
    public function findToken(
        LexerProgress $lexerProgress,
        Token $token
    ): Token {
        $lookahead = $lexerProgress->getContentLookahead();

        $foundString = Regex::match($token->getRegex(), $lookahead)
            ->result();

        if ($foundString === null) {
            throw TokenNotFound::forToken($token, $lexerProgress);
        }

        return $token::fromLexeme($foundString);
    }
}
