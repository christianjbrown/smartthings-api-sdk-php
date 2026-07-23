<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SubscriptionInterface
{
    public function getId(): string;

    public function getInstalledAppId(): ?string;

    public function getSourceType(): ?string;

    public function setId(string $value): self;

    public function setInstalledAppId(?string $value): self;

    public function setSourceType(?string $value): self;
}
