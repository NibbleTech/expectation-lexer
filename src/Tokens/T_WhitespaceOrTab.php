<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Tokens;

class T_WhitespaceOrTab extends AbstractToken
{
    public function getRegex(): string
    {
        return '/\s/';
    }
}
