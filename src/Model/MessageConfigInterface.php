<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MessageConfigInterface
{
    public function getMessageGroupKey(): ?string;

    public function setMessageGroupKey(?string $value): self;
}
