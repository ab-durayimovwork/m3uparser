<?php

namespace M3uParser\Tests;

use M3uParser\Exts\ExtInf;
use M3uParser\Interfaces\ExtInterface;
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

    /**
     * @return ExtInterface|ExtInf
     */
    private function getFirstExt()
    {
        return self::$channel->getExts()[0];
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
                ->setVal(-1)
        );

        $this->assertCount(1, self::$channel->getExts());
    }

    public function testExt()
    {
        $this->assertInstanceOf(ExtInf::class, $this->getFirstExt());
    }

    public function testEmptyExtAttributes()
    {
        $this->assertEmpty($this->getFirstExt()->getAttributes());
    }

    public function testExtAttributes()
    {
        $this->assertEquals('Первый канал', $this->getFirstExt()->getTitle());
        $this->assertEquals(-1, $this->getFirstExt()->getVal());
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