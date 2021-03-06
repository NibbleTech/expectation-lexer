<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexerConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use NibbleTech\ExpectationLexer\TokenFinder\StartOfStringTokenFinder;
use NibbleTech\ExpectationLexer\TokenFinder\TokenFinder;

final class ExpectOneResolver implements ExpectationResolver
{
    private TokenFinder $tokenFinder;

    public function __construct()
    {
        $this->tokenFinder = new StartOfStringTokenFinder();
    }

    public function resolve(
        LexerProgress $lexerProgress,
        LexerConfiguration $config,
        Expectation $expectation
    ): void {
        $expectOption = $expectation->getExpectOption();

        if (!$expectOption instanceof ExpectOne) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectOne::class);
        }

        $this->findAnyFillerTokens(
            $lexerProgress,
            $config
        );

        $foundToken = $this->tokenFinder->findToken(
            $lexerProgress,
            $expectOption->getToken(),
        );

        $lexerProgress->addFoundToken($foundToken);
    }

    private function findAnyFillerTokens(
        LexerProgress $lexerProgress,
        LexerConfiguration $config
    ): void {
        $fillerTokens = $config->getFillerTokens();

        foreach ($fillerTokens as $fillerToken) {
            try {
                $foundToken = $this->tokenFinder->findToken(
                    $lexerProgress,
                    $fillerToken
                );
                $lexerProgress->addFoundToken($foundToken);

                /**
                 * Filler token found so recurse into finding more filler tokens
                 * as the next one might be yet another filler token
                 */
                $this->findAnyFillerTokens(
                    $lexerProgress,
                    $config
                );

                /**
                 * Once the recursion passes we can just instantly return because we know there should be
                 * no further filler tokens otherwise the recursion would have found it.
                 */
                return;
            } catch (TokenNotFound) {
                continue;
            }
        }
    }
}
