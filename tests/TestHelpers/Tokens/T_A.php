<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\Tokens;

use NibbleTech\ExpectationLexer\Tokens\AbstractToken;

class T_A extends AbstractToken
{
    public function getRegex(): string
    {
        return '/a/';
    }
}
