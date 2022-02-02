<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectAny;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;

class ExpectAnyResolver implements ExpectationResolver
{
    private readonly ResolveExpectOption $resolveExpectOption;

    public function __construct()
    {
        $this->resolveExpectOption = new ResolveExpectOption();
    }

    public function resolve(
        LexerProgress $lexerProgress,
        ExpectOption $expectOption
    ): void {
        if (!$expectOption instanceof ExpectAny) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectAny::class);
        }

        // Discover any


        foreach ($expectOption->getExpectedNextOptions() as $expectedNextOption) {
            try {
                $this->resolveExpectOption->resolve(
                    $lexerProgress,
                    $expectedNextOption,
                );
            } catch (TokenNotFound) {
                continue;
            }
        }
    }
}
