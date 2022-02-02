<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
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
        LexerResult $lexerResult,
        ExpectOption $expectOption,
        StringContent $content
    ): void {
        if (!$expectOption instanceof ExpectAny) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectAny::class);
        }

        // Discover any


        foreach ($expectOption->getExpectedNextOptions() as $expectedNextOption) {
            try {
                $this->resolveExpectOption->resolve(
                    $lexerResult,
                    $expectedNextOption,
                    $content
                );
            } catch (TokenNotFound) {
                continue;
            }
        }
    }
}
