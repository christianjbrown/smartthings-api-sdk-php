<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppInterface
{
    public function getAppId(): string;

    public function getAppName(): ?string;

    public function getAppType(): ?string;

    public function getDisplayName(): ?string;

    public function setAppId(string $value): self;

    public function setAppName(?string $value): self;

    public function setAppType(?string $value): self;

    public function setDisplayName(?string $value): self;
}
