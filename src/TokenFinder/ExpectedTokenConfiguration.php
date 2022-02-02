<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;
use NibbleTech\ExpectationLexer\Tokens\Token;

class ExpectedTokenConfiguration
{
    private \NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder $expectedTokenOrder;
    /**
     * @var Token[]
     */
    private array $fillerTokens = [];
    /**
     * @var Token[]
     */
    private array $ignoredTokens = [];

    final private function __construct()
    {
    }

    /**
     * @param Token[]     $fillerTokens
     * @param Token[]     $ignoredTokens
     *
     */
    public static function create(
        ExpectOrder $expectedTokenOrder,
        array $fillerTokens = [],
        array $ignoredTokens = []
    ): ExpectedTokenConfiguration {
        $self = new static();

        $self->expectedTokenOrder = $expectedTokenOrder;
        $self->fillerTokens = $fillerTokens;
        $self->ignoredTokens = $ignoredTokens;

        return $self;
    }

    public function isIgnoredToken(Token $token): bool
    {
        foreach ($this->ignoredTokens as $ignoredToken) {
            if ($token instanceof $ignoredToken) {
                return true;
            }
        }

        return false;
    }

    public function isFillerToken(Token $token): bool
    {
        foreach ($this->fillerTokens as $fillerToken) {
            if ($token instanceof $fillerToken) {
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

    public function getExpectedTokenOrder(): ExpectOrder
    {
        return $this->expectedTokenOrder;
    }
}
