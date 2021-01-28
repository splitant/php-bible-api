<?php

namespace BibleAPI\Tests;

use BibleAPI\BibleAPI;
use PHPUnit_Framework_TestCase;

class BibleAPITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BibleAPI\BibleAPI
     */
    protected $bibleAPI;

    public function setUp()
    {
        parent::setUp();
        $this->bibleAPI = new BibleAPI();
    }

    /**
     * @dataProvider providerBibleVersions
     */
    public function testGetBibleVersions($expected_result)
    {
        $this->assertEquals($this->bibleAPI->getBibleVersions(), $expected_result);
    }

    /**
     * @dataProvider providerBibleBooks
     */
    public function testGetBibleBooks($expected_result)
    {
        $this->assertEquals($this->bibleAPI->getBibleBooks(), $expected_result);
    }

    /**
     * @dataProvider providerVersesFromBook
     */
    public function testGetVersesFromBook($version, $book, $chapter, $nb_verses_expected)
    {
        $this->bibleAPI->getVersesFromBook($version, $book);

        $verses = $this->bibleAPI->getVerses();
        $this->assertNotNull($verses);
        $this->assertEquals(count($verses[$version . '.' . $book]['chapters'][$chapter]), $nb_verses_expected);
    }

    /**
     * @dataProvider providerVersesData
     */
    public function testGetVerse($version, $book, $chapter, $num_verse, $content_verse)
    {
        $this->assertEquals($this->bibleAPI->getVerse($version, $book, $chapter, $num_verse), $content_verse);
    }

    /**
     * List of bible versions available.
     */
    public function providerBibleVersions()
    {
        return [
            [[
                "LSG" => "Louis-Segond", 
                "semeur" => "Semeur", 
                "segond_21" => "Segond 21", 
                "martin" => "Martin", 
                "darby" => "Darby", 
                "ostervald" => "Ostervald", 
                "kingjames" => "King-James", 
                "COL" => "La Colombe", 
                "PDV" => "Parole de Vie", 
                "PVI" => "Parole Vivante", 
                "BFC" => "La Bible en français courant", 
                "NBS" => "Nouvelle Bible Segond", 
                "NFC" => "Nouvelle Français courant", 
                "BCC1923" => "Bible catholique Crampon 1923",
            ]],
        ];
    }

    /**
     * List of bible books available.
     */
    public function providerBibleBooks()
    {
        return [
            [[
                'genese' => 'Genèse', 
                'exode' => 'Exode', 
                'levitique' => 'Lévitique', 
                'nombres' => 'Nombres', 
                'deuteronome' => 'Deutéronome', 
                'josue' => 'Josué', 
                'juges' => 'Juges', 
                'ruth' => 'Ruth', 
                '1-samuel' => '1 Samuel', 
                '2-samuel' => '2 Samuel', 
                '1-rois' => '1 Rois', 
                '2-rois' => '2 Rois', 
                '1-chroniques' => '1 Chroniques', 
                '2-chroniques' => '2 Chroniques', 
                'esdras' => 'Esdras', 
                'nehemie' => 'Néhémie', 
                'esther' => 'Esther', 
                'job' => 'Job', 
                'psaumes' => 'Psaumes', 
                'proverbes' => 'Proverbes', 
                'ecclesiaste' => 'Ecclésiaste', 
                'cantique-des-cantiques' => 'Cantique des cantiques', 
                'esaie' => 'Esaïe', 
                'jeremie' => 'Jérémie', 
                'lamentations' => 'Lamentations', 
                'ezechiel' => 'Ezéchiel', 
                'daniel' => 'Daniel', 
                'osee' => 'Osée', 
                'joel' => 'Joël', 
                'amos' => 'Amos', 
                'abdias' => 'Abdias', 
                'jonas' => 'Jonas', 
                'michee' => 'Michée', 
                'nahum' => 'Nahum',
                'habakuk' => 'Habakuk',
                'sophonie' => 'Sophonie',
                'agee' => 'Aggée', 
                'zacharie' => 'Zacharie', 
                'malachie' => 'Malachie', 
                'matthieu' => 'Matthieu', 
                'marc' => 'Marc', 
                'luc' => 'Luc', 
                'jean' => 'Jean', 
                'actes' => 'Actes', 
                'romains' => 'Romains', 
                '1-corinthiens' => '1 Corinthiens', 
                '2-corinthiens' => '2 Corinthiens', 
                'galates' => 'Galates', 
                'ephesiens' => 'Ephésiens', 
                'philippiens' => 'Philippiens', 
                'colossiens' => 'Colossiens', 
                '1-thessaloniciens' => '1 Thessaloniciens', 
                '2-thessaloniciens' => '2 Thessaloniciens', 
                '1-timothee' => '1 Timothée', 
                '2-timothee' => '2 Timothée', 
                'tite' => 'Tite', 
                'philemon' => 'Philémon', 
                'hebreux' => 'Hébreux', 
                'jacques' => 'Jacques', 
                '1-pierre' => '1 Pierre', 
                '2-pierre' => '2 Pierre', 
                '1-jean' => '1 Jean', 
                '2-jean' => '2 Jean', 
                '3-jean' => '3 Jean', 
                'jude' => 'Jude', 
                'apocalypse' => 'Apocalypse'
            ]],
        ];
    }

    /**
     * List of testing data.
     */
    public function providerVersesFromBook()
    {
        return [
            ['LSG', 'genese', '1', 31],
            ['semeur', 'levitique', '6', 23],
            ['kingjames', 'job', '20', 176],
            ['PDV', 'psaumes', '119', 176],
        ];
    }

    /**
     * List of testing verses data.
     */
    public function providerVersesData()
    {
        return [
            ['segond_21', 'luc', '6', '30', 'Ce que vous voulez que les hommes fassent pour vous, faites-le [vous aussi] de même pour eux.'],
            ['kingjames', 'jean', '15', '13', 'Greater love hath no man than this, that a man lay down his life for his friends.'],
            ['NBS', '1-corinthiens', '13', '13', 'Or maintenant trois choses demeurent : la foi, l’espérance, l’amour ; mais c’est l’amour qui est le plus grand.'],
            ['NFC', 'genese', '1', '1', 'Au commencement Dieu créa les cieux et la terre .'],
            ['ostervald', 'genese', '1', '51', 'Ainsi furent achevés les cieux et la terre, et toute leur armée.'],
            ['BFC', 'actes', '2', '-1', 'Ils tirèrent alors au sort et le sort désigna Matthias, qui fut donc associé aux onze apôtres.'],
        ];
    }
}
