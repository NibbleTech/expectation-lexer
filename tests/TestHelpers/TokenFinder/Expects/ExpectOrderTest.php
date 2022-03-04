<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TestHelpers\TokenFinder\Expects;

use InvalidArgumentException;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;
use PHPUnit\Framework\TestCase;

class ExpectOrderTest extends TestCase
{
    public function test_it_throws_on_not_passing_expectations(): void
    {
        $this->expectExceptionObject(
            new InvalidArgumentException("Given Expectation is not an instance of " . Expectation::class)
        );

        /** @psalm-suppress InvalidArgument */
        ExpectOrder::with([1,2,3]);
    }
}
