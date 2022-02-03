<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectOneResolver;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\AssertTokens;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TokenFinder\ExpectedTokenConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use NibbleTech\ExpectationLexer\Tokens\T_Tab;
use NibbleTech\ExpectationLexer\Tokens\T_WhitespaceOrTab;
use NibbleTech\ExpectationLexer\Tokens\UnclassifiedToken;
use PHPUnit\Framework\TestCase;

class ExpectOneResolverTest extends TestCase
{
    /**
     * @covers \NibbleTech\ExpectationLexer\Lexer\Expectations\Resolution\ExpectOneResolver::resolve
     */
    public function test_expect_one_resolves()
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

    /**
     * @covers
     */
    public function test_it_handles_filler_tokens()
    {
        $config = ExpectedTokenConfiguration::create(
            Expect::order([
                Expect::one(T_A::token()),
            ]),
            [
                T_WhitespaceOrTab::token(),
            ]
        );


        $content = StringContent::with("\t\t  a");

        $lexerProgress = LexerProgress::new(
            $config,
            $content
        );

        AssertTokens::assertTokens(
            $lexerProgress,
            new ExpectOneResolver(),
            Expect::one(T_A::token()),
            [
                T_WhitespaceOrTab::fromLexeme("\t"),
                T_WhitespaceOrTab::fromLexeme("\t"),
                T_WhitespaceOrTab::fromLexeme(' '),
                T_WhitespaceOrTab::fromLexeme(' '),
                T_A::fromLexeme('a'),
            ]
        );
    }
}
