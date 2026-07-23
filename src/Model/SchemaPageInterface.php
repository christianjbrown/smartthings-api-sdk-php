<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaPageInterface
{
    public function getAppName(): ?string;

    public function getIsaId(): ?string;

    public function getLocationId(): ?string;

    public function getOAuthLink(): ?string;

    public function getPageType(): string;

    public function getPartnerName(): ?string;

    public function setAppName(?string $value): self;

    public function setIsaId(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setOAuthLink(?string $value): self;

    public function setPageType(string $value): self;

    public function setPartnerName(?string $value): self;
}
