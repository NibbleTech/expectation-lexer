<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexingContent;

use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\UnclassifiedToken;
use PHPUnit\Framework\TestCase;

class StringContentTest extends TestCase
{
    private string $dummyText = "this is a test medium";

    private StringContent $content;

    protected function setUp(): void
    {
        $this->content = StringContent::with($this->dummyText);
    }

    /**
     * @covers StringContent::progressForToken()
     */
    public function test_it_increments_cursor_from_token_and_returns_correct_text() {
        $testToken = UnclassifiedToken::fromLexeme("this");
        
        $this->content->progressForToken($testToken);

        self::assertEquals(4, $this->content->getCursorPosition());
        self::assertEquals(" is a test medium", $this->content->getLookahead());
    }
}
