<?php

namespace M3uParser\Tests;

use M3uParser\Exception;
use M3uParser\Parser;
use M3uParser\PlaylistContent\LocalPlaylistContent;
use M3uParser\PlaylistContent\RemotePlaylistContent;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseLocalFileFail(): void
    {
        $this->expectException(Exception::class);

        $content = new LocalPlaylistContent(__DIR__ . '/fixtures/nofile.m3u');

        $m3uParser = new Parser($content);
        $m3uParser->parseContent();
    }

    public function testParseRemoteFileFail(): void
    {
        $this->expectException(Exception::class);

        $content = new RemotePlaylistContent('https://ya.ru/asd');

        $m3uParser = new Parser($content);
        $m3uParser->parseContent();
    }

    public function testParseLocalFileSuccess(): void
    {
        $content = new LocalPlaylistContent(__DIR__ . '/fixtures/playlist.m3u');

        $m3uParser = new Parser($content);
        $m3uParser->addDefaultTags();
        $playlist = $m3uParser->parseContent();

        $this->assertEquals('http://epg.it999.ru/edem.xml.gz', $playlist->getAttribute('url-tvg'));
        $this->assertEquals('default', $playlist->getAttribute('catchup'));
        $this->assertEquals('7', $playlist->getAttribute('catchup-days'));
    }

    public function testParseRemoteFileSuccess(): void
    {
        $content = new RemotePlaylistContent('https://pbox.su/AWe5GY0r4kDxLvIX2lf7ZPab1gB9Kzwn.m3u');

        $m3uParser = new Parser($content);
        $m3uParser->addDefaultTags();
        $playlist = $m3uParser->parseContent();

        $this->assertEquals('http://epg.it999.ru/edem.xml.gz', $playlist->getAttribute('url-tvg'));
    }

    public function testParseFileEmptyAttributes(): void
    {
        $content = new LocalPlaylistContent(__DIR__ . '/fixtures/emptyattributes.m3u');

        $m3uParser = new Parser($content);
        $m3uParser->addDefaultTags();
        $playlist = $m3uParser->parseContent();

        $this->assertEmpty($playlist->getAttributes());
    }
}