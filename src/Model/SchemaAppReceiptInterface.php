<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppReceiptInterface
{
    public function getEndpointAppId(): ?string;

    public function getStClientId(): ?string;

    public function getStClientSecret(): ?string;

    public function setEndpointAppId(?string $value): self;

    public function setStClientId(?string $value): self;

    public function setStClientSecret(?string $value): self;
}
