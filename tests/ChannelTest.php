<?php

namespace M3uParser\Tests;

use M3uParser\Exts\ExtInf;
use M3uParser\Parser\Channel;
use M3uParser\Parser\Playlist;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    protected static $channel;

    public static function setUpBeforeClass(): void
    {
        self::$channel = new Channel;
    }

    public function testPath()
    {
        self::$channel->setPath('https://ya.ru');

        $this->assertEquals('https://ya.ru', self:: $channel->getPath());
    }

    public function testExts()
    {
        self::$channel->addExt(
            (new ExtInf)
                ->setTitle('Первый канал')
                ->setDuration(-1)
        );

        $this->assertCount(1, self::$channel->getExts());
    }

    public function testExt()
    {
        $this->assertInstanceOf(ExtInf::class, self::$channel->getExts()[0]);
    }

    public function testEmptyExtAttributes()
    {
        $this->assertEmpty(self::$channel->getExts()[0]->getAttributes());
    }

    public function testExtAttributes()
    {
        $this->assertEquals('Первый канал', self::$channel->getExts()[0]->getTitle());
        $this->assertEquals(-1, self::$channel->getExts()[0]->getDuration());
    }

    public function testPlaylist(): void
    {
        $playlist = new Playlist;
        $playlist->append(self::$channel);

        $expected = '#EXTM3U' . PHP_EOL .
            '#EXTINF:-1, Первый канал' . PHP_EOL .
            'https://ya.ru';

        $this->assertEquals($expected, $playlist->__toString());
    }

    public function testEmptyExts()
    {
        self::$channel->clearExts();

        $this->assertCount(0, self::$channel->getExts());
    }
}