<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use NibbleTech\ExpectationLexer\Tokens\Token;

final class ExpectOne implements ExpectOption
{
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

    public function getToken(): Token
    {
        return $this->token;
    }
}
