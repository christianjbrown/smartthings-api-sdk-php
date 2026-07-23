<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ChannelInterface
{
    public function getChannelId(): string;

    public function getDescription(): ?string;

    public function getName(): ?string;

    public function getTermsOfServiceUrl(): ?string;

    public function getType(): ?string;

    public function setChannelId(string $value): self;

    public function setDescription(?string $value): self;

    public function setName(?string $value): self;

    public function setTermsOfServiceUrl(?string $value): self;

    public function setType(?string $value): self;
}
