<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;
use NibbleTech\ExpectationLexer\Tokens\Token;

class ExpectedTokenConfiguration
{
    private Expectation $expectation;
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
        Expectation $expectation,
        array $fillerTokens = []
    ): ExpectedTokenConfiguration {
        $self = new static();

        $self->expectation  = $expectation;
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

    public function getExpectation(): Expectation
    {
        return $this->expectation;
    }
}
