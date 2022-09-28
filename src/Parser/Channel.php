<?php

namespace M3uParser\Parser;

use M3uParser\Interfaces\ExtInterface;

class Channel
{
    /**
     * @var string
     */
    protected $lineDelimiter = PHP_EOL;
    /**
     * @var ExtInterface[]
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
            $out .= $extTag.$this->lineDelimiter;
        }

        $out .= $this->getPath();

        return \rtrim($out);
    }

    /**
     * @return ExtInterface[]
     */
    public function getExts(): array
    {
        return $this->exts;
    }

    /**
     * @return $this
     */
    public function addExt(ExtInterface $ext): self
    {
        $this->exts[] = $ext;

        return $this;
    }

    /**
     * Remove all previously defined tags.
     *
     * @return $this
     */
    public function clearExts(): self
    {
        $this->exts = [];

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
