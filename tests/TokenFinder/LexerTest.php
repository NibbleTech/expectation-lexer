<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\TokenFinder;

use NibbleTech\ExpectationLexer\Exceptions\ContentStillLeftToParse;
use NibbleTech\ExpectationLexer\Exceptions\TokenNotFound;
use NibbleTech\ExpectationLexer\Expectations\Resolution\ResolveExpectOption;
use NibbleTech\ExpectationLexer\LexingContent\StringContent;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_A;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_B;
use NibbleTech\ExpectationLexer\TestHelpers\Tokens\T_C;
use NibbleTech\ExpectationLexer\TokenFinder\Expects\Expect;
use PHPUnit\Framework\TestCase;

class LexerTest extends TestCase
{

    /**
     * @covers Lexer::lex
     */
    public function test_it_throws_exception_when_cant_find_expected_token()
    {
        $example = StringContent::with("B");

        $config = ExpectedTokenConfiguration::create();

        $tokenFinder = new Lexer(
            $config,
            new ResolveExpectOption()
        );

        self::expectException(TokenNotFound::class);

        $tokenFinder->lex(

            Expect::order(
                [
                    Expect::one(T_A::token()),
                ]
            ),
            $example
        );
    }

    /**
     * @covers Lexer::lex
     */
    public function test_it_throws_when_still_content_leftover(): void
    {
        $example = StringContent::with("abcd");

        $config = ExpectedTokenConfiguration::create();

        $tokenFinder = new Lexer(
            $config,
            new ResolveExpectOption()
        );

        self::expectException(ContentStillLeftToParse::class);

        $tokenFinder->lex(
            Expect::order(
                [
                    Expect::one(T_A::token()),
                    Expect::one(T_B::token()),
                    Expect::one(T_C::token()),
                ]
            ),
            $example
        );
    }


    public function notyet_test_it_finds_literal_tokens()
    {
        $config = ExpectedTokenConfiguration::create();

        $text = "foobarbaz";

        $this->beConstructedWith($config);

        $lexerResult = $this->findTokens($text);

        $lexerResult->getTokens()->shouldBeLike([
            T_Literal::fromLexeme('foo'),
            T_Literal::fromLexeme('bar'),
            T_Literal::fromLexeme('baz'),
        ]);
    }
//
//    public function test_it_finds_case_insensitive_literals()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_Literal::of('foo')),
//                    Expect::one(T_Literal::of('bar')->caseInsensitive()),
//                ]
//            ),
//        );
//
//        $text = "fooBAR";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_Literal::fromLexeme('foo'),
//            T_Literal::fromLexeme('BAR'),
//        ]);
//    }
//
//    public function test_it_finds_one_token()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_With::token()),
//                ]
//            ),
//        );
//
//        $text = "with:";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:')
//        ]);
//    }
//
//    public function test_it_finds_one_repeating_token()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(
//                        T_With::token()
//                    )->repeating()
//                ]
//            ),
//        );
//
//        $text = "with:with:with:with:";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//            T_With::fromLexeme('with:'),
//            T_With::fromLexeme('with:'),
//            T_With::fromLexeme('with:'),
//        ]);
//    }
//
//    public function test_it_finds_multiple_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(
//                        T_With::token()),
//                    Expect::one(T_When::token()),
//                    Expect::one(T_Entity::token()),
//                ]
//            ),
//        );
//
//        $text = "with:whenFoo";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//            T_When::fromLexeme('when'),
//            T_Entity::fromLexeme('Foo'),
//        ]);
//    }
//
//    public function test_it_finds_multiple_tokens_with_whitespace_and_newline_filler_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_With::token()),
//                    Expect::one(T_When::token()),
//                    Expect::one(T_Entity::token()),
//                ]
//            ),
//            [
//                T_Whitespace::token(),
//                T_Newline::token(),
//            ],
//            [
//            ]
//        );
//
//        $text = "with: when \nFoo";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//            T_Whitespace::fromLexeme(' '),
//            T_When::fromLexeme('when'),
//            T_Whitespace::fromLexeme(' '),
//            T_Newline::fromLexeme("\n"),
//            T_Entity::fromLexeme('Foo'),
//        ]);
//    }
//
//    public function test_it_finds_repeating_token_in_amongst_other_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_With::token()),
//                    Expect::one(T_When::token())->repeating(),
//                    Expect::one(T_Entity::token()),
//                ]
//            ),
//        );
//
//        $text = "with:whenwhenwhenFoo";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//            T_When::fromLexeme('when'),
//            T_When::fromLexeme('when'),
//            T_When::fromLexeme('when'),
//            T_Entity::fromLexeme('Foo'),
//        ]);
//    }
//
//    public function test_it_finds_one_of_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::anyOf([
//                        Expect::one(T_With::token()),
//                        Expect::one(T_When::token()),
//                    ]),
//                ]
//            ),
//        );
//
//        $text = "with:";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//        ]);
//
//        $text = "when";
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_When::fromLexeme('when'),
//        ]);
//    }
//
//    public function test_it_finds_one_of_nested_one_of_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::anyOf([
//                        Expect::anyOf([
//                            Expect::one(T_With::token()),
//                            Expect::one(T_Entity::token()),
//                        ]),
//                        Expect::one(T_When::token()),
//                    ]),
//                ]
//            ),
//        );
//
//        $text = "with:";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//        ]);
//
//        $text = "Foo";
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_Entity::fromLexeme('Foo'),
//        ]);
//
//        $text = "when";
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_When::fromLexeme('when'),
//        ]);
//    }
//
//    public function test_it_finds_order_among_tokens()
//    {
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_With::token()),
//                    Expect::order([
//                        Expect::one(T_When::token()),
//                        Expect::one(T_When::token()),
//                        Expect::one(T_When::token()),
//                        Expect::one(T_When::token()),
//                    ]),
//                    Expect::one(T_Entity::token()),
//                ]
//            ),
//            [
//                T_Whitespace::fromLexeme(' ')
//            ],
//            [
//                T_Whitespace::fromLexeme(' ')
//            ]
//        );
//
//        $text = "with: when when when when Foo";
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($text);
//
//        $lexerResult->getTokens()->shouldBeLike([
//            T_With::fromLexeme('with:'),
//            T_When::fromLexeme('when'),
//            T_When::fromLexeme('when'),
//            T_When::fromLexeme('when'),
//            T_When::fromLexeme('when'),
//            T_Entity::fromLexeme('Foo'),
//        ]);
//    }
//
//
//    public function test_it_handles_a_nested_order_with_any_of_as_first_in_order()
//    {
////        When ThingSent
//
//        $example = <<<TEXT
//When ThingSent
//update Thing
//with: When
//TEXT;
//
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_When::token()),
//                    Expect::one(T_Event::token()),
//                    Expect::order([
//                        Expect::anyOf([
//                            Expect::one(T_Crud_Create::token()),
//                            Expect::one(T_Crud_Update::token()),
//                            Expect::one(T_Crud_Delete::token()),
//                        ]),
//                        Expect::one(T_Entity::token()),
//                        Expect::one(T_With::token()),
//                    ]),
//                    Expect::one(T_When::token()),
//                ]
//            ),
//            [
//                T_Whitespace::token(),
//                T_Newline::token(),
//            ],
//            [
//                T_Whitespace::token(),
//                T_Newline::token(),
//            ]
//        );
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($example);
//
//        $lexerResult->getTokens()->shouldBeLike(
//            [
//                T_When::fromLexeme('When'),
//                T_Event::fromLexeme('ThingSent'),
//                T_Crud_Update::fromLexeme('update'),
//                T_Entity::fromLexeme('Thing'),
//                T_With::fromLexeme('with:'),
//                T_When::fromLexeme('When'),
//            ]
//        );
//    }
//
//
//    public function test_it_handles_a_big_example()
//    {
//        $example = <<<TEXT
//Instruction: Creating thing
//
//When ThingSent
//create Thing
//with:
//    foo:bar
//    bar:baz
//    another:thing
//delete Bar
//with:
//    foo:bar
//    bar:baz
//TEXT;
//
//        $config = ExpectedTokenConfiguration::create(
//            Expect::order(
//                [
//                    Expect::one(T_Instruction_Label::token()),
//                    Expect::one(T_Instruction_Value::token()),
//                    Expect::one(T_When::token()),
//                    Expect::one(T_Event::token()),
//                    Expect::order([
//                        Expect::anyOf([
//                            Expect::one(T_Crud_Create::token()),
//                            Expect::one(T_Crud_Update::token()),
//                            Expect::one(T_Crud_Delete::token()),
//                        ]),
//                        Expect::one(T_Entity::token()),
//                        Expect::one(T_With::token()),
//                        Expect::one(T_Prop_Map_Item::token())->repeating(),
//                    ])->repeating(),
//                ]
//            ),
//            [
//                T_Whitespace::token(),
//                T_Newline::token(),
//            ],
//            [
//                T_Whitespace::token(),
//                T_Newline::token(),
//            ]
//        );
//
//        $this->beConstructedWith($config);
//
//        $lexerResult = $this->findTokens($example);
//
//        $lexerResult->getTokens()->shouldBeLike(
//            [
//                T_Instruction_Label::fromLexeme('Instruction:'),
//                T_Instruction_Value::fromLexeme('Creating thing'),
//                T_When::fromLexeme('When'),
//                T_Event::fromLexeme('ThingSent'),
//                T_Crud_Create::fromLexeme('create'),
//                T_Entity::fromLexeme('Thing'),
//                T_With::fromLexeme('with:'),
//                T_Prop_Map_Item::fromLexeme('foo:bar'),
//                T_Prop_Map_Item::fromLexeme('bar:baz'),
//                T_Prop_Map_Item::fromLexeme('another:thing'),
//                T_Crud_Delete::fromLexeme('delete'),
//                T_Entity::fromLexeme('Bar'),
//                T_With::fromLexeme('with:'),
//                T_Prop_Map_Item::fromLexeme('foo:bar'),
//                T_Prop_Map_Item::fromLexeme('bar:baz'),
//            ]
//        );
//    }

}
