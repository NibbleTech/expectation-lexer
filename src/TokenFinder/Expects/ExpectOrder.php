<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class ExpectOrder implements ExpectOption
{
    /**
     * @var Expectation[]
     */
    private $order = [];

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

        $self        = new static();
        $self->order = $expectations;

        return $self;
    }

    /**
     * @return Expectation[]
     */
    public function getExpectationOrder(): array
    {
        return $this->order;
    }
}
