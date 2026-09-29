<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaOauthCredentialsRequest implements SchemaOauthCredentialsRequestInterface
{
    private ?string $endpointAppId = null;

    public function getEndpointAppId(): ?string
    {
        return $this->endpointAppId;
    }

    public function setEndpointAppId(?string $value): SchemaOauthCredentialsRequestInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }
}
