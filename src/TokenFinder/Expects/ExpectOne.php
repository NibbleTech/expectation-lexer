<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use NibbleTech\ExpectationLexer\Tokens\Token;

class ExpectOne implements ExpectOption
{
    use RepeatingTrait;

    private Token $token;

    final private function __construct()
    {
    }

    public static function of(Token $token): ExpectOne
    {
        $self = new static();

        $self->token = $token;

        return $self;
    }

    public function getExpectedNextOptions(): array
    {
        return [
            $this
        ];
    }

    public function getOptionsToFind(): array
    {
        return [
            $this
        ];
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getTokenClass(): string
    {
        return $this->token::class;
    }
}
