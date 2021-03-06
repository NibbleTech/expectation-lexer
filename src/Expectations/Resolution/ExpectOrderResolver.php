<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexerConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;

final class ExpectOrderResolver implements ExpectationResolver
{
    private readonly ResolveExpectOption $resolver;

    public function __construct(

    ) {
        $this->resolver = new ResolveExpectOption();
    }

    public function resolve(
        LexerProgress $lexerProgress,
        LexerConfiguration $config,
        Expectation $expectation
    ): void {
        $expectOption = $expectation->getExpectOption();

        if (!$expectOption instanceof ExpectOrder) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectOrder::class);
        }

        foreach ($expectOption->getExpectationOrder() as $orderedExpectOption) {
            $this->resolver->resolve(
                $lexerProgress,
                $config,
                $orderedExpectOption
            );
        }
    }
}
