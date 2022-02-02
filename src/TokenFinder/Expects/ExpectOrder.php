<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class ExpectOrder implements ExpectOption
{
    use RepeatingTrait;

    /**
     * @var ExpectOption
     */
    private $firstExpects;
    /**
     * @var ExpectOption[]
     */
    private $subsequentExpects = [];
    /**
     * @var ExpectOption[]
     */
    private $allExpects = [];

    final private function __construct()
    {
    }

    /**
     * @param ExpectOption[] $expectOptions
     */
    public static function with(array $expectOptions): ExpectOrder
    {
        foreach ($expectOptions as $expectOption) {
            /** @psalm-suppress DocblockTypeContradiction */
            if (!$expectOption instanceof ExpectOption) {
                throw new InvalidArgumentException("Given ExpectOption is not an instance of " . ExpectOption::class);
            }
        }

        $self = new static();
        $self->allExpects = $expectOptions;

        $first = array_shift($expectOptions);
        $self->firstExpects = $first;
        $self->subsequentExpects = $expectOptions;

        return $self;
    }

    public function getExpectedNextOptions(): array
    {
        return [
            $this->firstExpects
        ];
    }

    public function getOptionsToFind(): array
    {
        return $this->allExpects;
    }

    /**
     * @return ExpectOption[]
     */
    public function getSubsequentTokens(): array
    {
        return $this->subsequentExpects;
    }

    /**
     * @return ExpectOption[]
     */
    public function getAllExpects(): array
    {
        return $this->allExpects;
    }
}
