<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerResult;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;

class Lexer
{
    public function __construct(
        private readonly ExpectedTokenConfiguration $config,
        private readonly ResolveExpectOption $resolver
    ) {
    }

    public function lex(StringContent $content): LexerResult
    {
        $lexerResult = LexerResult::new();

        $this->resolver->resolve(
            $lexerResult,
            $this->config->getExpectedTokenOrder(),
            $content
        );
    }
}
