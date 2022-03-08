<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Spatie\Regex\Regex;

final class StartOfStringTokenFinder implements TokenFinder
{
    public function findToken(
        LexerProgress $lexerProgress,
        Token $token
    ): Token {
        $lookahead = $lexerProgress->getContentLookahead();

        /**
         * Force "start of string" condition on regex string
         */
        $regex = "/^" . substr($token->getRegex(), 1, strlen($token->getRegex()));

        $foundString = Regex::match($regex, $lookahead)
            ->result();

        if ($foundString === null) {
            throw TokenNotFound::forToken($token, $lexerProgress);
        }

        return $token::fromLexeme($foundString);
    }
}
