<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexingContent;

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

    public function getLookahead(
        int $cursorPosition
    ): string {
        return substr(
            $this->content,
            $cursorPosition
        );
    }

    public function getLookbehind(
        int $cursorPosition
    ): string {
        return substr(
            $this->content,
            0,
            $cursorPosition
        );
    }
}
