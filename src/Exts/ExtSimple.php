<?php

namespace M3uParser\Exts;

use M3uParser\Interfaces\ExtInterface;

abstract class ExtSimple implements ExtInterface
{
    /**
     * @var string
     */
    protected $val;

    public static $tag_name = '';

    /**
     * @param string|null $lineStr
     */
    public function __construct(?string $lineStr = null)
    {
        if (null !== $lineStr) {
            $this->make($lineStr);
        }
    }

    /**
     * @param string $lineStr
     */
    protected function make(string $lineStr)
    {
        $data = \substr($lineStr, strlen(static::$tag_name . ':'));

        $this->setVal(trim($data));
    }

    /**
     * @return string
     */
    public function getVal(): string
    {
        return $this->val;
    }

    /**
     * @param string $data
     *
     * @return $this
     */
    public function setVal(string $data): self
    {
        $this->val = $data;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::$tag_name . ':' . $this->getVal();
    }

    /**
     * @param string $lineStr
     *
     * @return bool
     */
    public static function isMatch(string $lineStr): bool
    {
        return 0 === stripos($lineStr, static::$tag_name . ':');
    }
}
