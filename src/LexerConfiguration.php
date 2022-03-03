<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer;

use NibbleTech\ExpectationLexer\Tokens\Token;

final class LexerConfiguration
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
    ): LexerConfiguration {
        $self = new static();

        $self->fillerTokens = $fillerTokens;

        return $self;
    }

    /**
     * @return Token[]
     */
    public function getFillerTokens(): array
    {
        return $this->fillerTokens;
    }
}
