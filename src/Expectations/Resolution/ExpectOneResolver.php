<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOption;
use NibbleTech\ExpectationLexer\TokenFinder\TokenFinder;

class ExpectOneResolver implements ExpectationResolver
{
    public function resolve(
        LexerResult $lexerResult,
        ExpectOption $expectOption,
        StringContent $content
    ): void {
        if (!$expectOption instanceof ExpectOne) {
            throw WrongExpectOption::shouldBe($expectOption, ExpectOne::class);
        }

        $tokenFinder = new TokenFinder();

        $foundToken = $tokenFinder->findToken($content, $expectOption->getToken());

        $lexerResult->addFoundToken($foundToken);
        $content->progressForToken($foundToken);
    }
}
