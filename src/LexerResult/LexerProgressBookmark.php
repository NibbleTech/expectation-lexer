<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use Ramsey\Uuid\UuidInterface;

class LexerProgressBookmark
{
    public function __construct(
        private UuidInterface $id,
        private int $tokenCount
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTokenCount(): int
    {
        return $this->tokenCount;
    }
}
