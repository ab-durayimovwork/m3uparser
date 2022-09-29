<?php

namespace M3uParser\Exts;

use M3uParser\Interfaces\ExtInterface;

abstract class ExtSimple implements ExtInterface
{
    /**
     * @var string
     */
    protected $val;

    public static $tagName = '';

    public function __construct(?string $lineStr = null)
    {
        if (null !== $lineStr) {
            $this->make($lineStr);
        }
    }

    public function __toString(): string
    {
        return static::$tagName . ':' . $this->getVal();
    }

    public static function isMatch(string $lineStr): bool
    {
        return 0 === stripos($lineStr, static::$tagName . ':');
    }

    public function make(string $lineStr)
    {
        $data = \substr($lineStr, strlen(static::$tagName . ':'));

        $this->setVal(trim($data));
    }

    public function getVal(): string
    {
        return $this->val;
    }

    public function setVal(string $data): self
    {
        $this->val = $data;

        return $this;
    }
}
