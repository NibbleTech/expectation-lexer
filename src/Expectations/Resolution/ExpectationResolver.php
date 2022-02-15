<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;

interface ExpectationResolver
{
    public function resolve(
        LexerProgress $lexerProgress,
        ExpectedTokenConfiguration $config,
        Expectation $expectation
    ): void;
}
