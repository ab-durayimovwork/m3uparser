<?php

namespace M3uParser\Parser;

use ArrayIterator;
use M3uParser\Traits\ExtAttributesTrait;

class Playlist extends ArrayIterator
{
    use ExtAttributesTrait;

    public function __toString(): string
    {
        $out = rtrim('#EXTM3U ' . $this->getAttributesString()) . PHP_EOL;

        foreach ($this as $entry) {
            $out .= $entry . PHP_EOL;
        }

        return rtrim($out);
    }
}
