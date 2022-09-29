<?php

namespace M3uParser\Exts;

use M3uParser\Traits\ExtAttributesTrait;

class ExtInf extends ExtSimple
{
    use ExtAttributesTrait;

    public static $tagName = '#EXTINF';

    /**
     * @var string
     */
    private $title;

    public function __toString(): string
    {
        return parent::__toString() . $this->getAttributesString() . ', ' . $this->getTitle();
    }

    public function make(string $lineStr): void
    {
        /*
            #EXTINF:<duration> [<attributes-list>], <title>

            example:
            #EXTINF:-1 tvg-name=Первый_HD tvg-logo="Первый канал" deinterlace=4 group-title="Эфирные каналы",Первый канал HD
         */
        $dataLineStr = \substr($lineStr, 8);

        \preg_match('/^ ?(-?\d+)\s*(?:(?:[^=]+=["\'][^"\']*["\'])|(?:[^=]+=[^ ]*))*\s?,(.*)$/', $dataLineStr, $matches);

        if (empty($matches)) {
            $this->setTitle('');

            return;
        }

        $this->setVal((int)$matches[1]);
        $this->setTitle(\trim($matches[2]));

        $attributes = \preg_replace('/^' . \preg_quote($matches[1], '/') . '(.*)' . \preg_quote($matches[2], '/') . '$/', '$1', $dataLineStr);

        $splitAttributes = \explode(' ', $attributes, 2);

        if (isset($splitAttributes[1]) && $trimmedAttributes = \trim($splitAttributes[1])) {
            $this->initAttributes($trimmedAttributes);
        }
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
