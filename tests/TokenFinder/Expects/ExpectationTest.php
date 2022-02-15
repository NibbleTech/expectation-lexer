<?php

declare(strict_types=1);

namespace TokenFinder\Expects;

use InvalidArgumentException;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use PHPUnit\Framework\TestCase;

class ExpectationTest extends TestCase
{
    /**
     * @covers
     */
    public function test_it_does_not_allow_invalid_max_occurances(): void
    {
        $expectOne = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtMost(-1);
    }
    /**
     * @covers
     */
    public function test_it_does_not_allow_invalid_min_occurances(): void
    {
        $expectOne = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtLeast(-1);
    }
}
