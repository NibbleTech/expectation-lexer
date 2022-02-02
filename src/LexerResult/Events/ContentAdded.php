<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult\Events;

use NibbleTech\ExpectationLexer\LexingContent\StringContent;

class ContentAdded implements LexerEvent
{
    public function __construct(
        private StringContent $content
    ) {
    }

    public function getContent(): StringContent
    {
        return $this->content;
    }
}
