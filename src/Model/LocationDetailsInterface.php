<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationDetailsInterface
{
    public function getParent(): ?LocationParentInterface;

    public function setParent(?LocationParentInterface $value): self;
}
