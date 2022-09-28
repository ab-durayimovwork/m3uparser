<?php

namespace M3uParser\Tests;

use M3uParser\Exception;
use M3uParser\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseFileFail(): void
    {
        $this->expectException(Exception::class);

        $m3uParser = new Parser;
        $m3uParser->parseFile(__DIR__ . '/fixtures/nofile.m3u');
    }

    public function testParseFileSuccess(): void
    {
        $m3uParser = new Parser;
        $m3uParser->addDefaultTags();
        $playlist = $m3uParser->parseFile(__DIR__ . '/fixtures/playlist.m3u');

        $this->assertEquals('http://epg.it999.ru/edem.xml.gz', $playlist->getAttribute('url-tvg'));
        $this->assertEquals('default', $playlist->getAttribute('catchup'));
        $this->assertEquals('7', $playlist->getAttribute('catchup-days'));
    }

    public function testParseFileEmptyAttributes(): void
    {
        $m3uParser = new Parser;
        $m3uParser->addDefaultTags();
        $playlist = $m3uParser->parseFile(__DIR__ . '/fixtures/emptyattributes.m3u');

        $this->assertEmpty($playlist->getAttributes());
    }
}