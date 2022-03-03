<?php

declare(strict_types=1);

namespace NibbleTech\ExpectationLexer\LexerResult;

use RuntimeException;

final class LexerProgressBookmarkCollection
{
    private int $highestTokenCount = 0;
    /**
     * @param LexerProgressBookmark[] $bookmarks
     */
    public function __construct(
        private array $bookmarks = []
    ) {
    }

    public function addBookmark(LexerProgressBookmark $bookmark): void
    {
        if ($bookmark->getTokenCount() < $this->highestTokenCount) {
            throw new RuntimeException('Cannot add bookmark with lower token count');
        }

        $this->bookmarks[] = $bookmark;
        $this->highestTokenCount = $bookmark->getTokenCount();
    }

    public function hasBookmark(LexerProgressBookmark $checkBookmark): bool
    {
        foreach ($this->bookmarks as $bookmark) {
            if ($bookmark->getId()->equals($checkBookmark->getId())) {
                return true;
            }
        }

        return false;
    }

    public function rewindToBookmark(LexerProgressBookmark $rewindBookmark): void
    {
        if ($this->hasBookmark($rewindBookmark) === false) {
            throw new RuntimeException("Bookmark attempted to rewind to does not exist");
        }

        $newBookmarks = [];

        foreach ($this->bookmarks as $bookmark) {
            $newBookmarks[] = $bookmark;

            if ($bookmark->getId()->equals($rewindBookmark->getId())) {
                $this->bookmarks = $newBookmarks;
                return;
            }
        }
    }
}
