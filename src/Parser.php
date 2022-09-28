<?php

namespace M3uParser;

use Exception;
use M3uParser\Exception as M3uParserException;
use M3uParser\Interfaces\ExtInterface;
use M3uParser\Parser\Playlist;
use M3uParser\Parser\Channel;
use M3uParser\Traits\ExtManagerTrait;

class Parser
{
    use ExtManagerTrait;

    /**
     * @throws M3uParserException
     */
    public function parseFile(string $file): Playlist
    {
        try {
            $str = file_get_contents($file);
        } catch (Exception $e) {
            throw new M3uParserException($e);
        }

        return $this->parse($str);
    }

    /**
     * Parse m3u string.
     */
    public function parse(string $str): Playlist
    {
        $this->removeBom($str);

        $playlist = new Playlist;
        $lines = explode(PHP_EOL, $str);

        for ($i = 0, $l = sizeof($lines); $i < $l; ++$i) {
            $lineStr = trim($lines[$i]);

            if (empty($lineStr) || $this->isComment($lineStr)) {
                continue;
            }

            if ($this->isExtM3u($lineStr)) {
                $tmp = trim(substr($lineStr, 7));

                if ($tmp) {
                    $playlist->initAttributes($tmp);
                }

                continue;
            }

            $playlist->append($this->parseLine($i, $lines));
        }

        return $playlist;
    }

    /**
     * @param int $lineNumber
     * @param array $linesStr
     * @return Channel
     */
    protected function parseLine(int &$lineNumber, array $linesStr): Channel
    {
        $channel = new Channel;

        for ($l = sizeof($linesStr); $lineNumber < $l; ++$lineNumber) {
            $nextLineStr = $linesStr[$lineNumber];
            $nextLineStr = trim($nextLineStr);

            if (empty($nextLineStr) || $this->isComment($nextLineStr) || $this->isExtM3u($nextLineStr)) {
                continue;
            }

            $matched = false;

            /** @var ExtInterface $availableTag */
            foreach ($this->getTags() as $availableTag) {
                if ($availableTag::isMatch($nextLineStr)) {
                    $matched = true;
                    $channel->addExt(new $availableTag($nextLineStr));

                    break;
                }
            }

            if (!$matched) {
                $channel->setPath($nextLineStr);

                break;
            }
        }

        return $channel;
    }

    protected function removeBom(string &$str): void
    {
        if (0 === strpos($str, "\xEF\xBB\xBF")) {
            $str = substr($str, 3);
        }
    }

    protected function isExtM3u(string $lineStr): bool
    {
        return 0 === stripos($lineStr, '#EXTM3U');
    }

    protected function isComment(string $lineStr): bool
    {
        $matched = false;

        /** @var ExtInterface $availableTag */
        foreach ($this->getTags() as $availableTag) {
            if ($availableTag::isMatch($lineStr)) {
                $matched = true;

                break;
            }
        }

        return !$matched && 0 === strpos($lineStr, '#') && !$this->isExtM3u($lineStr);
    }
}
