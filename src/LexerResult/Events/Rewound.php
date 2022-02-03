<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult\Events;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgressBookmark;

class Rewound implements LexerEvent
{
    public function __construct(
        private LexerProgressBookmark $bookmark
    ) {
    }

    public function getBookmark(): LexerProgressBookmark
    {
        return $this->bookmark;
    }
}
