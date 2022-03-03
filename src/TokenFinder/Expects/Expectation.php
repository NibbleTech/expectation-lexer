<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

final class Expectation
{
    private bool $repeating = false;
    private int $minOccurances = 1;
    private int $maxOccurances = 1;
    private bool $optional = false;

    public function __construct(
        private ExpectOption $expectOption
    ) {
    }

    public function getExpectOption(): ExpectOption
    {
        return $this->expectOption;
    }

    public function repeats(): bool
    {
        return $this->repeating;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function optional(): self
    {
        $this->optional = true;

        return $this;
    }

    public function getMinOccurances(): int
    {
        return $this->minOccurances;
    }

    public function repeatsAtLeast(int $minOccurances): self
    {
        if ($minOccurances <= 0) {
            throw new InvalidArgumentException('$minOccurances must be a positive integer');
        }
        $this->repeating = true;
        $this->minOccurances = $minOccurances;
        /**
         * Dont allow max occurrences to conflict
         */
        if ($this->maxOccurances < $minOccurances) {
            $this->maxOccurances = $minOccurances;
        }

        return $this;
    }

    public function getMaxOccurances(): int
    {
        return $this->maxOccurances;
    }

    public function repeatsAtMost(int $maxOccurances): self
    {
        if ($maxOccurances <= 0) {
            throw new InvalidArgumentException('$maxOccurances must be a positive integer');
        }
        $this->repeating = true;
        $this->maxOccurances = $maxOccurances;
        /**
         * Dont allow min occurrences to conflict
         */
        if ($this->minOccurances > $maxOccurances) {
            $this->minOccurances = $maxOccurances;
        }

        return $this;
    }
}
