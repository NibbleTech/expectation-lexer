<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\ContentStillLeftToParse;
use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;

class Lexer
{
    public function __construct(
        private readonly ExpectedTokenConfiguration $config,
        private readonly ResolveExpectOption $resolver
    ) {
    }

    public function lex(StringContent $content): LexerProgress
    {
        $lexerProgress = LexerProgress::new(
            $this->config,
            $content
        );

        $this->resolver->resolve(
            $lexerProgress,
            $this->config->getExpectation(),
        );

        /**
         * Done parsing, if theres content left over, thats not right.
         */
        if ($lexerProgress->getContentLookahead() !== '') {
            throw ContentStillLeftToParse::withRemaining($lexerProgress->getContentLookahead());
        }

        return $lexerProgress;
    }
}
