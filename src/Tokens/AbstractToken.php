<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Tokens;

abstract class AbstractToken implements Token
{
    private string $lexeme;

    final protected function __construct()
    {
    }

    public static function token(): self
    {
        return new static();
    }

    public static function fromLexeme(string $lexeme): self
    {
        $self = new static();

        $self->lexeme = $lexeme;

        return $self;
    }

    public function getLexeme(): string
    {
        return $this->lexeme;
    }
}
