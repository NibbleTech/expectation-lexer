<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class ExpectAny implements ExpectOption
{
    /**
     * @var Expectation[]
     */
    private array $expects;

    final private function __construct()
    {
    }

    /**
     * @param Expectation[] $expectations
     */
    public static function of(array $expectations): ExpectAny
    {
        $self = new static();

        foreach ($expectations as $expectation) {
            /** @psalm-suppress DocblockTypeContradiction */
            if (!$expectation instanceof Expectation) {
                throw new InvalidArgumentException("Given ExpectOption is not an instance of " . Expectation::class);
            }
        }

        $self->expects = $expectations;

        return $self;
    }

    /**
     * @return Expectation[]
     */
    public function getExpectedNextOptions(): array
    {
        return $this->expects;
    }
}
