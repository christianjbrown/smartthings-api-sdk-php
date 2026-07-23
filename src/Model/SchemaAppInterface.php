<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInterface
{
    public function getAppName(): ?string;

    public function getCertificationStatus(): ?string;

    public function getEndpointAppId(): string;

    public function getPartnerName(): ?string;

    public function getStClientId(): ?string;

    public function setAppName(?string $value): self;

    public function setCertificationStatus(?string $value): self;

    public function setEndpointAppId(string $value): self;

    public function setPartnerName(?string $value): self;

    public function setStClientId(?string $value): self;
}
