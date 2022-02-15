<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectAny;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;
use RuntimeException;

/**
 * Take the lexer result and the current ExpectOption,
 */
class ResolveExpectOption
{
    public function resolve(
        LexerProgress $lexerProgress,
        ExpectedTokenConfiguration $config,
        Expectation $expectation
    ): void {
        $resolver = $this->getResolver($expectation->getExpectOption());

        $foundCounter = 0;

        while ($foundCounter < $expectation->getMaxOccurances()) {
            try {
                $resolver->resolve(
                    $lexerProgress,
                    $config,
                    $expectation
                );
            } catch (TokenNotFound $e) {
                if ($expectation->isOptional() === false) {
                    throw $e;
                }
            }

            $foundCounter++;

            if ($expectation->repeats()) {
                if ($foundCounter < $expectation->getMinOccurances()) {
                    // continue
                }
            }
        }


        // repeating stuff could happen here, but would require the discovery stuff maybe?
        // need non cursor altering matching. but that could still just be within the resolve
        // step maybe. if it doesnt resolve, it'll throw an exception, if it does resolve we want
        // that because we're doing repeating stuff
    }

    private function getResolver(ExpectOption $expectOption): ExpectationResolver
    {
        return match ($expectOption::class) {
            ExpectOrder::class => new ExpectOrderResolver(),
            ExpectAny::class => new ExpectAnyResolver(),
            ExpectOne::class => new ExpectOneResolver(),
            default => throw new RuntimeException(
                'No Resolver support for ExpectOption of type [' . $expectOption::class . ']'
            ),
        };
    }
}
