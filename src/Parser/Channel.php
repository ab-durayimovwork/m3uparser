<?php

namespace M3uParser\Parser;

use M3uParser\Interfaces\ExtInterface;

class Channel
{
    /**
     * @var array
     */

    private $exts = [];

    /**
     * @var null|string
     */
    private $path;

    public function __toString(): string
    {
        $out = '';

        foreach ($this->getExts() as $extTag) {
            $out .= $extTag . PHP_EOL;
        }

        $out .= $this->getPath();

        return rtrim($out);
    }

    public function getExts(): array
    {
        return $this->exts;
    }

    public function addExt(ExtInterface $ext): self
    {
        $this->exts[] = $ext;

        return $this;
    }

    public function clearExts(): self
    {
        $this->exts = [];

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
