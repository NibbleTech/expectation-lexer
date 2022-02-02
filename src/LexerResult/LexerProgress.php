<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\Events\LexerEvent;
use NibbleTech\ExpectationLexer\LexerResult\Events\TokenFound;
use NibbleTech\ExpectationLexer\Tokens\Token;
use ReflectionClass;

/**
 * Event Sourced to enable rewinding functionality to support branch resolution in the ExpectedTokenConfiguration
 */
class LexerProgress
{
    /**
     * @var LexerEvent[]
     */
    private array $eventStore = [];
    /**
     * @var Token[]
     */
    private array $tokens = [];

    final private function __construct()
    {
    }

    public static function new(): LexerProgress
    {
        return new static();
    }

    /**
     * @return Token[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
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
    }
}
