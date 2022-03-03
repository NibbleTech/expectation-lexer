<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Tokens;

final class UnclassifiedToken extends AbstractToken
{
    private string $regex;

    public static function withRegex(string $regex): self
    {
        $self = new self();

        $self->regex = $regex;

        return $self;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }
}
