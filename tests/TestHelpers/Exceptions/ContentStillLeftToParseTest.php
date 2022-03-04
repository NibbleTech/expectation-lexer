<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\Exceptions;

use NibbleTech\ExpectationLexer\Exceptions\ContentStillLeftToParse;
use PHPUnit\Framework\TestCase;

class ContentStillLeftToParseTest extends TestCase
{
    public function test_it_has_right_message(): void
    {
        $exception = ContentStillLeftToParse::withRemaining("foofoofoofoo");

        $this->assertEquals(
            "Content leftover after completed parsing. Content: foofoofoof",
            $exception->getMessage()
        );
    }
}
