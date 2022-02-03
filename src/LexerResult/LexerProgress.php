<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\Events\Bookmarked;
use NibbleTech\ExpectationLexer\LexerResult\Events\ContentAdded;
use NibbleTech\ExpectationLexer\LexerResult\Events\LexerEvent;
use NibbleTech\ExpectationLexer\LexerResult\Events\Rewound;
use NibbleTech\ExpectationLexer\LexerResult\Events\TokenFound;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\Token;
use Ramsey\Uuid\Uuid;
use ReflectionClass;

/**
 * Event Sourced to enable rewinding functionality to support branch resolution in the ExpectedTokenConfiguration
 */
class LexerProgress
{
    private StringContent $content;
    /**
     * @var LexerEvent[]
     */
    private array $eventStore = [];
    /**
     * @var Token[]
     */
    private array $tokens = [];

    private LexerProgressBookmarkCollection $bookmarks;

    final private function __construct(
        StringContent $content
    ) {
        $this->bookmarks = new LexerProgressBookmarkCollection();

        $contentAdded = new ContentAdded(
            $content
        );
        $this->applyEvent($contentAdded);
    }

    public static function new(
        StringContent $content
    ): LexerProgress {
        return new self(
            $content
        );
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function getContent(): StringContent
    {
        return $this->content;
    }

    public function addFoundToken(Token $token): void
    {
        $event = new TokenFound($token);

        $this->applyEvent($event);
    }

    public function bookmark(): LexerProgressBookmark
    {
        $bookmark   = new LexerProgressBookmark(
            Uuid::uuid4(),
            count($this->tokens)
        );
        $bookmarked = new Bookmarked(
            $bookmark
        );

        $this->applyEvent($bookmarked);

        return $bookmark;
    }

    public function rewind(LexerProgressBookmark $bookmark): void
    {
        $rewound = new Rewound($bookmark);

        $this->applyEvent($rewound);
    }

    private function applyEvent(LexerEvent $event): void
    {
        $this->eventStore[] = $event;

        $reflection = new ReflectionClass($event);

        $method = 'applyEvent' . $reflection->getShortName();

        $this->$method($event);
    }

    private function applyEventTokenFound(TokenFound $tokenFound): void
    {
        $this->tokens[] = $tokenFound->getToken();
    }

    private function applyEventContentAdded(ContentAdded $contentAdded): void
    {
        $this->content = $contentAdded->getContent();
    }

    private function applyEventBookmarked(Bookmarked $bookmarked): void
    {
        $this->bookmarks->addBookmark($bookmarked->getBookmark());
    }

    private function applyEventRewound(Rewound $rewound): void
    {
        $this->bookmarks->rewindToBookmark($rewound->getBookmark());

        $this->tokens = array_slice(
            $this->tokens,
            0,
            $rewound->getBookmark()->getTokenCount()
        );
    }

    public function getContentCursorPosition(): int
    {
        $cursorPosition = 0;

        foreach ($this->tokens as $token) {
            $cursorPosition += strlen($token->getLexeme());
        }

        return $cursorPosition;
    }

    public function getContentLookahead(): string
    {
        return $this->content->getLookahead(
            $this->getContentCursorPosition()
        );
    }
}
