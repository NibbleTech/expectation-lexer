<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\Events\ContentAdded;
use NibbleTech\ExpectationLexer\LexerResult\Events\LexerEvent;
use NibbleTech\ExpectationLexer\LexerResult\Events\TokenFound;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\Tokens\Token;
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

    final private function __construct(
        StringContent $content
    ) {
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

    public function applyEvent(LexerEvent $event): void
    {
        $this->eventStore[] = $event;

        $reflection = new ReflectionClass($event);

        $method = 'applyEvent' . $reflection->getShortName();

        $this->$method($event);
    }

    private function applyEventTokenFound(TokenFound $tokenFound): void
    {
        $this->tokens[] = $tokenFound->getToken();
        $this->content->progressForToken($tokenFound->getToken());
    }

    public function applyEventContentAdded(ContentAdded $contentAdded): void
    {
        $this->content = $contentAdded->getContent();
    }
}
