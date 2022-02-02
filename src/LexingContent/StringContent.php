<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexingContent;

use NibbleTech\ExpectationLexer\Tokens\Token;

class StringContent
{
    private string $content;

    private int $cursorPosition = 0;

    public static function with(string $content): self
    {
        $self = new self();

        $self->content = $content;

        return $self;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getLookahead(): string
    {
        return substr(
            $this->content,
            $this->cursorPosition
        );
    }

    public function getLookbehind(): string
    {
        return substr(
            $this->content,
            0,
            $this->cursorPosition
        );
    }

    public function getCursorPosition(): int
    {
        return $this->cursorPosition;
    }

    public function progressForToken(Token $token): void
    {
        $this->incrementCursorPosition(
            strlen($token->getLexeme())
        );
    }

    private function incrementCursorPosition(int $amount): void
    {
        $this->cursorPosition += $amount;
    }
}
