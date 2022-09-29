<?php

namespace M3uParser\Tests;

use M3uParser\Exts\ExtEnc;
use M3uParser\Exts\ExtIcon;
use M3uParser\Exts\ExtInf;
use M3uParser\Exts\ExtLogo;
use M3uParser\Parser\Channel;
use M3uParser\Parser\Playlist;
use PHPUnit\Framework\TestCase;

class PlaylistTest extends TestCase
{
    public function testPlaylist(): void
    {
        $channel = new Channel;
        $channel->setPath('https://ya.ru');
        $channel->addExt(
            (new ExtInf)
                ->setVal(-1)
                ->setTitle('Первый канал')
                ->setAttribute('group', 'Общественные')
        );
        $channel->addExt(
            (new ExtIcon)
                ->setVal('https://app.playlistbox.com/icon/LqEygb36eAPXvx4jejZw1B4J20a7VGdn.png')
        );
        $channel->addExt(
            (new ExtLogo)
                ->setVal('https://app.playlistbox.com/icon/LqEygb36eAPXvx4jejZw1B4J20a7VGdn.png')
        );
        $channel->addExt(
            (new ExtEnc)
                ->setVal('UTF-8')
        );

        $this->assertCount(4, $channel->getExts());

        $playlist = new Playlist;
        $playlist->setAttribute('url-tvg', 'http://epg.it999.ru/edem.xml.gz');
        $playlist->append($channel);

        $expected = '#EXTM3U  url-tvg="http://epg.it999.ru/edem.xml.gz"' . PHP_EOL .
            '#EXTINF:-1 group="Общественные", Первый канал' . PHP_EOL .
            '#ICON:https://app.playlistbox.com/icon/LqEygb36eAPXvx4jejZw1B4J20a7VGdn.png' . PHP_EOL .
            '#EXTLOGO:https://app.playlistbox.com/icon/LqEygb36eAPXvx4jejZw1B4J20a7VGdn.png' . PHP_EOL .
            '#EXTENC:UTF-8' . PHP_EOL .
            'https://ya.ru';

        $this->assertEquals($expected, $playlist->__toString());
    }
}