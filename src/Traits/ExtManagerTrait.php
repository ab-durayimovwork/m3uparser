<?php

namespace M3uParser\Traits;

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

    public function addTag(ExtInterface $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    public function addDefaultTags(): self
    {
        $this->addTag(new ExtInf);
        $this->addTag(new ExtLogo);
        $this->addTag(new ExtIcon);
        $this->addTag(new ExtEnc);

        return $this;
    }

    public function clearTags(): self
    {
        $this->tags = [];

        return $this;
    }

    protected function getTags(): array
    {
        return $this->tags;
    }
}
