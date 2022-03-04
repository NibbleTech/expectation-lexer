<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Exceptions\WrongExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\AssertTokens;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\LexerConfiguration;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use NibbleTech\ExpectationLexer\Tokens\T_WhitespaceOrTab;
use PHPUnit\Framework\TestCase;

class ExpectOneResolverTest extends TestCase
{
    public function test_it_throws_on_wrong_expectation_passed(): void
    {
        $expectation = Expect::anyOf([Expect::one(T_A::token())]);

        $this->expectExceptionObject(
            new WrongExpectOption('Unsupported ExpectOption given [' . $expectation->getExpectOption()::class . '], should be [' . ExpectOne::class . ']')
        );

        (new ExpectOneResolver())->resolve(
            LexerProgress::new(
                StringContent::with("")
            ),
            LexerConfiguration::create(),
            $expectation,
        );
    }


    public function test_expect_one_resolves(): void
    {
        $expectOption = Expect::one(T_A::token());

        AssertTokens::assertResolved(
            new ExpectOneResolver(),
            $expectOption,
            StringContent::with('a'),
            [
                T_A::fromLexeme('a')
            ]
        );
    }


    public function test_it_handles_filler_tokens(): void
    {
        $config = LexerConfiguration::create(
            [
                T_B::token(),
                T_WhitespaceOrTab::token(),
            ]
        );


        $content = StringContent::with("\t\tbb  a");

        $lexerProgress = LexerProgress::new(
            $content
        );

        AssertTokens::assertTokens(
            $lexerProgress,
            $config,
            new ExpectOneResolver(),
            Expect::one(T_A::token()),
            [
                T_WhitespaceOrTab::fromLexeme("\t"),
                T_WhitespaceOrTab::fromLexeme("\t"),
                T_B::fromLexeme('b'),
                T_B::fromLexeme('b'),
                T_WhitespaceOrTab::fromLexeme(' '),
                T_WhitespaceOrTab::fromLexeme(' '),
                T_A::fromLexeme('a'),
            ]
        );
    }
}
