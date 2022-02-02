<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\Expectations\Resolution;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectOneResolver;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\AssertTokens;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
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
}
