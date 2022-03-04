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
    public function test_it_sets_repeating_at_least(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $expectation->repeatsAtLeast(5);

        $this->assertEquals(
            5,
            $expectation->getMinOccurances(),
        );
        $this->assertEquals(
            5,
            $expectation->getMaxOccurances(),
        );
        $this->assertTrue(
            $expectation->repeats()
        );
    }

    public function test_it_sets_repeating_at_most(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $expectation->repeatsAtMost(5);

        $this->assertEquals(
            1,
            $expectation->getMinOccurances(),
        );
        $this->assertEquals(
            5,
            $expectation->getMaxOccurances(),
        );
        $this->assertTrue(
            $expectation->repeats()
        );
    }

    public function test_at_least_and_at_most_correct_conflicts(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $expectation->repeatsAtLeast(5);
        $expectation->repeatsAtMost(3);

        $this->assertEquals(
            3,
            $expectation->getMinOccurances(),
        );
        $this->assertEquals(
            3,
            $expectation->getMaxOccurances(),
        );
        $this->assertTrue(
            $expectation->repeats()
        );

        $expectation->repeatsAtMost(5);
        $expectation->repeatsAtLeast(8);

        $this->assertEquals(
            8,
            $expectation->getMinOccurances(),
        );
        $this->assertEquals(
            8,
            $expectation->getMaxOccurances(),
        );
        $this->assertTrue(
            $expectation->repeats()
        );
    }

    public function test_it_does_not_allow_negative_max_occurances(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtMost(-1);
    }

    public function test_it_does_not_allow_zero_max_occurances(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtMost(0);
    }

    public function test_it_does_not_allow_negative_min_occurances(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtLeast(-1);
    }

    public function test_it_does_not_allow_zero_min_occurances(): void
    {
        $expectOne   = ExpectOne::of(T_A::token());
        $expectation = new Expectation($expectOne);

        $this->expectException(InvalidArgumentException::class);

        $expectation->repeatsAtLeast(0);
    }
}
