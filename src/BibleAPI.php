<?php

/**
 * @file
 * Contains \BibleAPI\BibleAPI.
 */

namespace BibleAPI;

class BibleAPI
{
    protected const SOURCE_DIRECTORY = 'resources';

    /**
     * Root path.
     *
     * @var string
     */
    private $root;

    /**
     * Array of available bible versions.
     *
     * @var array
     */
    protected $bibleVersions;

    /**
     * Array of available bible books.
     *
     * @var array
     */
    protected $bibleBooks;

    /**
     * Current bible version.
     *
     * @var string
     */
    protected $currentVersion;

    /**
     * Current bible book.
     *
     * @var string
     */
    protected $currentBook;

    /**
     * Current bible chapter.
     *
     * @var string
     */
    protected $currentChapter;

    /**
     * Current bible verse.
     *
     * @var string
     */
    protected $currentVerse;

    /**
     * Array of bible verses.
     *
     * @var array
     */
    protected $verses;

    /**
     * Constructs instance of BibleAPI
     *
     * @param string $current_version
     *   (optional) Provided bible version.
     * @param string $current_book
     *   (optional) Provided bible book.
     * @param string $current_chapter
     *   (optional) Provided bible chapter.
     * @param string $current_verse
     *   (optional) Provided bible verse.
     */
    public function __construct($current_version = '', $current_book = '', $current_chapter = '', $current_verse = '') {
        $this->root = dirname(__DIR__);
        
        $this->bibleVersions = [];
        $this->bibleBooks = [];

        $this->currentVersion = $current_version;
        $this->currentBook = $current_book;
        $this->currentChapter = $current_chapter;
        $this->currentVerse = $current_verse;

        $this->verses = [];
    }

    /**
     * Getter for verses.
     *
     * @return array
     *   Array of bible verses.
     */
    public function getVerses()
    {
        return $this->verses;
    }

    /**
     * Getter for currentVersion.
     *
     * @return string
     *   Current bible version.
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * Getter for currentBook.
     *
     * @return string
     *   Current bible book.
     */
    public function getCurrentBook()
    {
        return $this->currentBook;
    }

    /**
     * Getter for currentChapter.
     *
     * @return string
     *   Current bible chapter.
     */
    public function getCurrentChapter()
    {
        return $this->currentChapter;
    }

    /**
     * Getter for currentVerse.
     *
     * @return string
     *   Current bible verse.
     */
    public function getCurrentVerse()
    {
        return $this->currentVerse;
    }

    /**
     * Getter for bibleVersions.
     *
     * @return array
     *   Array of bible versions.
     */
    public function getBibleVersions()
    {
        if (empty($this->bibleVersions)) {
            $path = $this->root . '/' . self::SOURCE_DIRECTORY . '/bible_versions.json';
            $data_encoded = file_get_contents($path);
            $this->bibleVersions = json_decode($data_encoded, TRUE);
        }

        return $this->bibleVersions;
    }

    /**
     * Getter for bibleBooks.
     *
     * @return array
     *   Array of bible books.
     */
    public function getBibleBooks()
    {
        if (empty($this->bibleBooks)) {
            $path = $this->root . '/' . self::SOURCE_DIRECTORY . '/bible_books.json';
            $data_encoded = file_get_contents($path);
            $data_books = json_decode($data_encoded, TRUE);

            foreach($data_books as $data_book) {
                $this->bibleBooks[$data_book['code_book']] = $data_book['label_book'];
            }

        }

        return $this->bibleBooks;
    }

    /**
     * Get verses from a version and a book.
     *
     * @param string $version
     *   Bible book version.
     * @param string $book
     *   Bible book.
     * 
     * @return array
     *   Array of verses.
     */
    public function getVersesFromBook($version, $book) {
        $this->currentVersion = $version;
        $this->currentBook = $book;

        $key_version_book = $this->currentVersion . '.' . $this->currentBook;

        if (empty($this->verses[$key_version_book])) {
            $path = $this->root . '/' . self::SOURCE_DIRECTORY . '/' . $this->currentVersion . '/' . $this->currentBook . '.json';
            $data_encoded = file_get_contents($path);
            $this->verses[$key_version_book] = json_decode($data_encoded, TRUE);
        }

        return $this->verses[$key_version_book]['chapters'];
    }

    /**
     * Get specific verse from version, book, chapter and verse num.
     *
     * @param string $version
     *   Bible book version.
     * @param string $book
     *   Bible book name.
     * @param string $chapter
     *   Bible book chapter.
     * @param string $num_verse
     *   Bible book verse num.
     * 
     * @return string
     *   Content verse.
     */
    public function getVerse($version, $book, $chapter, $num_verse) {
        $verse = '';
        $verses = $this->getVersesFromBook($version, $book);

        if (!empty($verses[$chapter])) {
            $this->currentChapter = $chapter;

            if (empty($verses[$chapter][$num_verse])) {
                if (intval($num_verse) <= 0) {
                    $new_chapter = intval($chapter) - 1;
                } elseif (intval($num_verse) > count($verses[$chapter])) {
                    $new_chapter = intval($chapter) + 1;
                }

                if (!empty($verses[strval($new_chapter)])) {
                    if ($new_chapter < intval($this->currentChapter)) {
                        $new_verse_number = count($verses[strval($new_chapter)]);
                    } else {
                        $new_verse_number = 1;
                    }

                    $this->currentChapter = strval($new_chapter);
                    $this->currentVerse = strval($new_verse_number);
                    $verse = $verses[$this->currentChapter][strval($new_verse_number)];
                }
            } 
            else {
                $verse = $verses[$this->currentChapter][$num_verse];
                $this->currentVerse = $num_verse;
            }
        }

        return $verse;
    }

    /**
     * Get a set of verses depending of a pattern.
     * 
     * @todo Implement it.
     *
     * @param string $pattern
     *   Pattern string to found. It can be a regex or a specific word.
     * @param string $version
     *   Bible book version.
     * @param string $book
     *   Bible book name.
     * @param string $chapter
     *   Bible book chapter.
     * 
     * @return array
     *   Array of verses with the pattern.
     */
    public function getVersesFromSearch($pattern, $version = '', $book = '', $chapter = '') {
        return [];
    }
}
