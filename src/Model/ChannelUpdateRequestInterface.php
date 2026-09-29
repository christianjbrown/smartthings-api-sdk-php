<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ChannelUpdateRequestInterface
{
    public function getDescription(): ?string;

    public function getName(): ?string;

    public function getTermsOfServiceUrl(): ?string;

    public function setDescription(?string $value): self;

    public function setName(?string $value): self;

    public function setTermsOfServiceUrl(?string $value): self;
}
