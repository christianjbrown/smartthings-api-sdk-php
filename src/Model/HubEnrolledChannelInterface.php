<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubEnrolledChannelInterface
{
    public function getChannelId(): string;

    public function getDescription(): ?string;

    public function getName(): ?string;

    public function getSubscriptionUrl(): ?string;

    public function setChannelId(string $value): self;

    public function setDescription(?string $value): self;

    public function setName(?string $value): self;

    public function setSubscriptionUrl(?string $value): self;
}
