<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectAny;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
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
        ExpectedTokenConfiguration $config,
        Expectation $expectation
    ): void {
        $expectOption = $expectation->getExpectOption();

        if (!$expectOption instanceof ExpectAny) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectAny::class);
        }

        foreach ($expectOption->getExpectedNextOptions() as $expectedNextOption) {
            $bookmark = $lexerProgress->bookmark();
            try {
                $this->resolveExpectOption->resolve(
                    $lexerProgress,
                    $config,
                    $expectedNextOption,
                );
            } catch (TokenNotFound) {
                $lexerProgress->rewind($bookmark);
                continue;
            }
        }
    }
}
