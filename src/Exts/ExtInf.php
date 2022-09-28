<?php

namespace M3uParser\Exts;

use M3uParser\Interfaces\ExtInterface;
use M3uParser\Traits\ExtAttributesTrait;

class ExtInf implements ExtInterface
{
    use ExtAttributesTrait;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $duration;

    public function __construct(?string $lineStr = null)
    {
        if (null !== $lineStr) {
            $this->make($lineStr);
        }
    }

    public function __toString(): string
    {
        return '#EXTINF:' . $this->getDuration() . $this->getAttributesString() . ', ' . $this->getTitle();
    }

    /**
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return $this
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public static function isMatch(string $lineStr): bool
    {
        return 0 === \stripos($lineStr, '#EXTINF:');
    }

    /**
     * @param string $lineStr
     *
     * @see http://l189-238-14.cn.ru/api-doc/m3u-extending.html
     */
    protected function make(string $lineStr): void
    {
        /*
            #EXTINF:<duration> [<attributes-list>], <title>

            example:
            #EXTINF:-1 tvg-name=Первый_HD tvg-logo="Первый канал" deinterlace=4 group-title="Эфирные каналы",Первый канал HD
         */
        $dataLineStr = \substr($lineStr, 8);

        // Parse duration and title with regex
        \preg_match('/^ ?(-?\d+)\s*(?:(?:[^=]+=["\'][^"\']*["\'])|(?:[^=]+=[^ ]*))*\s?,(.*)$/', $dataLineStr, $matches);

        if (empty($matches)) {
            $this->setTitle('');

            return;
        }

        $this->setDuration((int)$matches[1]);
        $this->setTitle(\trim($matches[2]));

        // Attributes are remaining string after remove duration and title
        $attributes = \preg_replace('/^' . \preg_quote($matches[1], '/') . '(.*)' . \preg_quote($matches[2], '/') . '$/', '$1', $dataLineStr);

        $splitAttributes = \explode(' ', $attributes, 2);

        if (isset($splitAttributes[1]) && $trimmedAttributes = \trim($splitAttributes[1])) {
            $this->initAttributes($trimmedAttributes);
        }
    }
}