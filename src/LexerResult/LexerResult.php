<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use NibbleTech\ExpectationLexer\Tokens\Token;

class LexerResult
{
    /**
     * @var Token[]
     */
    private array $tokens = [];

    final private function __construct()
    {
    }

    public static function new(): LexerResult
    {
        return new static();
    }

    public function addFoundToken(Token $token): void
    {
        $this->tokens[] = $token;
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
