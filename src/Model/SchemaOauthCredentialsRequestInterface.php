<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaOauthCredentialsRequestInterface
{
    public function getEndpointAppId(): ?string;

    public function setEndpointAppId(?string $value): self;
}
