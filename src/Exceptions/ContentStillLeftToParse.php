<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Exceptions;

use Exception;

final class ContentStillLeftToParse extends Exception
{
    public static function withRemaining(string $remaining): self
    {
        return new self("Content leftover after completed parsing. Content: " . substr($remaining, 0, 10));
    }
}
