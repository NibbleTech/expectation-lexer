<?php

declare(strict_types=1);

namespace LexerResult;

use NibbleTech\ExpectationLexer\LexerResult\LexerProgressBookmark;
use NibbleTech\ExpectationLexer\LexerResult\LexerProgressBookmarkCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class LexerProgressBookmarkCollectionTest extends TestCase
{

    public function test_it_cannot_add_bookmark_with_lower_token_count(): void
    {
        $collection = new LexerProgressBookmarkCollection();

        $bookmark = new LexerProgressBookmark(
            Uuid::uuid4(),
            10
        );

        $collection->addBookmark($bookmark);

        $otherBookmark = new LexerProgressBookmark(
            Uuid::uuid4(),
            5
        );

        self::expectException(RuntimeException::class);

        $collection->addBookmark($otherBookmark);
    }


    public function test_it_can_rewind_to_bookmark(): void
    {
        $collection = new LexerProgressBookmarkCollection();

        $first = new LexerProgressBookmark(
            Uuid::uuid4(),
            1
        );
        $second = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );
        $third = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );
        $fourth = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );

        $collection->addBookmark($first);
        $collection->addBookmark($second);
        $collection->addBookmark($third);
        $collection->addBookmark($fourth);


        $collection->rewindToBookmark($second);

        self::assertEquals(true, $collection->hasBookmark($first));
        self::assertEquals(true, $collection->hasBookmark($second));
        self::assertEquals(false, $collection->hasBookmark($third));
        self::assertEquals(false, $collection->hasBookmark($fourth));
    }

    public function test_it_cannot_rewind_to_bookmark_that_does_not_exist(): void
    {
        $collection = new LexerProgressBookmarkCollection();

        $first = new LexerProgressBookmark(
            Uuid::uuid4(),
            1
        );
        $second = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );
        $third = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );
        $fourth = new LexerProgressBookmark(
            Uuid::uuid4(),
            2
        );

        $collection->addBookmark($first);
        $collection->addBookmark($second);
        $collection->addBookmark($third);
        $collection->addBookmark($fourth);


        $garbageBookmark = new LexerProgressBookmark(
            Uuid::uuid4(),
            100
        );

        $this->expectExceptionObject(
            new RuntimeException("Bookmark attempted to rewind to does not exist")
        );

        $collection->rewindToBookmark($garbageBookmark);
    }

}
