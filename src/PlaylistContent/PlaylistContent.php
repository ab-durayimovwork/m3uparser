<?php

namespace M3uParser\PlaylistContent;

use M3uParser\Interfaces\PlaylistContentInterface;

abstract class PlaylistContent implements PlaylistContentInterface
{
    /** @var string */
    protected $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }
}