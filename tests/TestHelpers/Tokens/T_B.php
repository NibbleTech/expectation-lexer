<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\Tokens;

use NibbleTech\ExpectationLexer\Tokens\AbstractToken;

class T_B extends AbstractToken
{
    public function getRegex(): string
    {
        return \LucLeroy\Regex\Regex::create()
            ->startOfString()
            ->chars('b')
            ->times(1)
            ->getRegex();
    }
}
