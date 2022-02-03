<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Tokens;

use LucLeroy\Regex\Charset;
use LucLeroy\Regex\Regex;

class T_WhitespaceOrTab extends AbstractToken
{
    public function getRegex(): string
    {
        return Regex::create()
            ->startOfString()
            ->whitespace()
            ->getRegex();
    }
}
