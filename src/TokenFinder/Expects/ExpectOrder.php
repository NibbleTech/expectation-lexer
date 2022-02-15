<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class ExpectOrder implements ExpectOption
{
    /**
     * @var Expectation
     */
    private $firstExpects;
    /**
     * @var Expectation[]
     */
    private $subsequentExpects = [];
    /**
     * @var Expectation[]
     */
    private $allExpects = [];

    final private function __construct()
    {
    }

    /**
     * @param Expectation[] $expectations
     */
    public static function with(array $expectations): ExpectOrder
    {
        foreach ($expectations as $expectation) {
            /** @psalm-suppress DocblockTypeContradiction */
            if (!$expectation instanceof Expectation) {
                throw new InvalidArgumentException("Given ExpectOption is not an instance of " . Expectation::class);
            }
        }

        $self = new static();
        $self->allExpects = $expectations;

        $first = array_shift($expectations);
        $self->firstExpects = $first;
        $self->subsequentExpects = $expectations;

        return $self;
    }

    public function getExpectedNextOptions(): array
    {
        return [
            $this->firstExpects
        ];
    }

    /**
     * @return Expectation[]
     */
    public function getSubsequentTokens(): array
    {
        return $this->subsequentExpects;
    }

    /**
     * @return Expectation[]
     */
    public function getAllExpects(): array
    {
        return $this->allExpects;
    }
}
