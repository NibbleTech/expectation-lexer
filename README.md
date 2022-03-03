# What

A configurable lexer where you define a strict order of expected tokens.

Unlike general lexers that will parse all text to convert it to a list of all tokens to then parse for validity.
This is a more "simplistic" approach that sort of does both steps in one.
Based on the configuration it will lex the text to generate the expected tokens, and immediately fail if the next bit of text fails to match any expectations.

# Why

I didnt understand how to write a general lexer so this was a fun achievable alternative.

# How

Basic complete example:

```php
<?php

use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\Lexer;
use NibbleTech\ExpectationLexer\LexerConfiguration;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOne;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\ExpectOrder;
use NibbleTech\ExpectationLexer\Tokens\T_WhitespaceOrTab;
use NibbleTech\ExpectationLexer\Tokens\Token;
use NibbleTech\ExpectationLexer\Tokens\UnclassifiedToken;

$fillerTokens = [
    T_WhitespaceOrTab::token(),
];

$lexer = new Lexer(
    LexerConfiguration::create(
        $fillerTokens
    ),
    new ResolveExpectOption()
);

$expectedOrder = ExpectOrder::with([
    Expect::one(UnclassifiedToken::withRegex("/a/"))
]);

$content = "abc";

/**
 * Array of new Token classes of the same types given in the ExpectOrder above,
 * but now populated with the discovered values from content.
 */
/** @var Token[] $result */
$result = $lexer->lex(
    $expectedOrder,
    $content
);


```


# Expectation Examples

These work with any expectation, `Expect::one()`, `Expect::anyOf()`, `Expect::order()` etc.

## Repeating

Can specify an expectation to repeat any amount of times.

```php
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use Your\Own\Tokens\T_Foo;

// 3 - 3
$expectOne = Expect::one(T_Foo::token())
    ->repeatsAtLeast(3);
$success = [
    "foofoofoo"
];
$fail = [
    "foo",
    "foofoofoofoo"
];
    
// 1 - 3
$expectOne = Expect::one(T_Foo::token())
    ->repeatsAtMost(3);
$success = [
    "foo",
    "foofoo",
    "foofoofoo",
];
$fail = [
    "foofoofoofoo"
];

// 3 - 10
$expectOne = Expect::one(T_Foo::token())
    ->repeatsAtLeast(3)
    ->repeatsAtMost(10);
$success = [
    "foofoofoo",
];
$fail = [
    "foo",
    "foofoo",
];
```

## Optional

If an expecation fails to match it wont be considered an error and will just move onto the next expectation
```php
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use Your\Own\Tokens\T_Foo;
use Your\Own\Tokens\T_Bar;

$expectOne = Expect::order([
    Expect::one(T_Foo::token())
        ->optional(),
    Expect::one(T_Bar::token())
]);
$success = [
    "foo",
    "bar"
];
    
```
