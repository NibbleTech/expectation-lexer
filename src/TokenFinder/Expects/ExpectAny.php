<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

use InvalidArgumentException;

class ExpectAny implements ExpectOption
{
    use RepeatingTrait;

    /**
     * @var ExpectOption[]
     */
    private array $expects;

    final private function __construct()
    {
    }

    /**
     * @param ExpectOption[] $expects
     */
    public static function of(array $expects): ExpectAny
    {
        $self = new static();

        foreach ($expects as $expect) {
            /** @psalm-suppress DocblockTypeContradiction */
            if (!$expect instanceof ExpectOption) {
                throw new InvalidArgumentException("Given ExpectOption is not an instance of " . ExpectOption::class);
            }
        }

        $self->expects = $expects;

        return $self;
    }

    public function getExpectedNextOptions(): array
    {
        return $this->expects;
    }

    public function getOptionsToFind(): array
    {
        return [
            $this
        ];
    }
}
