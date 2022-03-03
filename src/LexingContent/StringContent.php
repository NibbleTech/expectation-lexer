<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexingContent;

class StringContent
{
    private string $content;

    public static function with(string $content): self
    {
        $self = new self();

        $self->content = $content;

        return $self;
    }

    public function getLookahead(
        int $cursorPosition
    ): string {
        return substr(
            $this->content,
            $cursorPosition
        );
    }
}
