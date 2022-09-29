<?php

namespace M3uParser\Interfaces;

interface ExtInterface
{
    public function __construct(?string $lineStr = null);

    public function __toString(): string;

    public static function isMatch(string $lineStr): bool;

    public function make(string $lineStr);
}
