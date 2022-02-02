<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

interface ExpectOption
{
    /**
     * A list of all the options we must find.
     *
     * @return ExpectOption[]
     */
    public function getOptionsToFind(): array;

    /**
     * Array of possible options that we can find to match this option
     *
     * @return ExpectOption[]
     */
    public function getExpectedNextOptions(): array;

    public function isRepeating(): bool;

    public function repeating(): ExpectOption;
}
