<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\LexerResult;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;

interface ExpectationResolver
{
    public function resolve(
        LexerResult $lexerResult,
        ExpectOption $expectOption,
        StringContent $content
    ): void;
}
