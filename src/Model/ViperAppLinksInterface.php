<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ViperAppLinksInterface
{
    public function getAndroid(): ?string;

    public function getIos(): ?string;

    public function getIsLinkingEnabled(): ?bool;

    public function setAndroid(?string $value): self;

    public function setIos(?string $value): self;

    public function setIsLinkingEnabled(?bool $value): self;
}
