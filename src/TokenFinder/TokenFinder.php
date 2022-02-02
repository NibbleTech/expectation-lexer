<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Spatie\Regex\Regex;

class TokenFinder
{
    public function findToken(
        StringContent $content,
        Token $token
    ): Token {
        $lookahead = $content->getLookahead();

        $foundString = Regex::match($token->getRegex(), $lookahead)
            ->result();

        if ($foundString === null) {
            throw TokenNotFound::forToken($token, $content);
        }

        return $token::fromLexeme($foundString);
    }
}
