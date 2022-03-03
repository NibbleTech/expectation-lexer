<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Exceptions;

use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;
use Exception;

final class WrongExpectOption extends Exception
{
    public static function shouldBe(ExpectOption $actual, string $expected): self
    {
        return new self(
            'Unsupported ExpectOption given [' . $actual::class . '], should be [' . $expected . ']'
        );
    }
}
