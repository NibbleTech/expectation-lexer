<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer;

use NibbleTech\ExpectationLexer\Exceptions\ContentStillLeftToParse;
use NibbleTech\ExpectationLexer\Expectations\Resolution\ExpectationResolver;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgress;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expectation;

final class Lexer
{
    public function __construct(
        private readonly LexerConfiguration $config,
        private readonly ExpectationResolver $resolver
    ) {
    }

    public function lex(
        Expectation $expectation,
        StringContent $content
    ): LexerProgress {
        $lexerProgress = LexerProgress::new(
            $content
        );

        $this->resolver->resolve(
            $lexerProgress,
            $this->config,
            $expectation,
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
