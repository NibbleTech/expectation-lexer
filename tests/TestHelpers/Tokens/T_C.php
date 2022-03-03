<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\Tokens;

use NibbleTech\ExpectationLexer\Tokens\AbstractToken;

class T_C extends AbstractToken
{
    public function getRegex(): string
    {
        return '/c/';
    }
}
