<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder\Expects;

trait RepeatingTrait
{
    /**
     * @var bool
     */
    private $repeating = false;

    public function isRepeating(): bool
    {
        return $this->repeating;
    }

    public function repeating(): ExpectOption
    {
        $this->repeating = true;

        return $this;
    }
}
