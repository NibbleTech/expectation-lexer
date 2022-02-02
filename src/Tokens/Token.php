<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Tokens;

interface Token
{
    public const MANDATORY = 1;
    public const OPTIONAL = 2;

    /**
     * @return self
     */
    public static function fromLexeme(string $lexeme);

    public function getLexeme(): string;

    public function getRegex(): string;
}
