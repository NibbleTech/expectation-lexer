<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Tokens\Token;

class ExpectedTokenConfiguration
{
    /**
     * @var Token[]
     */
    private array $fillerTokens = [];

    final private function __construct()
    {
    }

    /**
     * @param Token[] $fillerTokens
     *
     */
    public static function create(
        array $fillerTokens = []
    ): ExpectedTokenConfiguration {
        $self = new static();

        $self->fillerTokens = $fillerTokens;

        return $self;
    }

    public function isIgnoredToken(Token $token): bool
    {
        foreach ($this->fillerTokens as $ignoredToken) {
            if ($token instanceof $ignoredToken) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Token[]
     */
    public function getFillerTokens(): array
    {
        return $this->fillerTokens;
    }
}
