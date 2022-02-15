<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class Expectation
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

    public function isRepeating(): bool
    {
        return $this->repeating;
    }

    public function repeats(): self
    {
        $this->repeating = true;

        return $this;
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

    public function setMinOccurances(int $minOccurances): void
    {
        if ($minOccurances <= 0) {
            throw new InvalidArgumentException('$minOccurances must be a positive integer');
        }
        $this->minOccurances = $minOccurances;
    }

    public function getMaxOccurances(): int
    {
        return $this->maxOccurances;
    }

    public function setMaxOccurances(int $maxOccurances): void
    {
        if ($maxOccurances <= 0) {
            throw new InvalidArgumentException('$maxOccurances must be a positive integer');
        }
        $this->maxOccurances = $maxOccurances;
    }
}
