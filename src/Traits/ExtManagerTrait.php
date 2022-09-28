<?php

namespace M3uParser\Traits;

use M3uParser\Exception;
use M3uParser\Interfaces\ExtInterface;
use M3uParser\Exts\ExtEnc;
use M3uParser\Exts\ExtIcon;
use M3uParser\Exts\ExtInf;
use M3uParser\Exts\ExtLogo;

trait ExtManagerTrait
{
    /**
     * @var array
     */
    private $tags = [];

    /**
     * @return $this
     * @throws Exception
     */
    public function addTag(string $tag): self
    {
        if (!\in_array(ExtInterface::class, \class_implements($tag), true)) {
            throw new Exception(\sprintf('The class %s must be implement interface %s', $tag, ExtInterface::class));
        }

        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function addDefaultTags(): self
    {
        $this->addTag(ExtInf::class);
        $this->addTag(ExtLogo::class);
        $this->addTag(ExtIcon::class);
        $this->addTag(ExtEnc::class);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearTags(): self
    {
        $this->tags = [];

        return $this;
    }

    /**
     * @return array
     */
    protected function getTags(): array
    {
        return $this->tags;
    }
}
