<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppReceipt implements SchemaAppReceiptInterface
{
    private ?string $endpointAppId = null;
    private ?string $stClientId = null;
    private ?string $stClientSecret = null;

    public function getEndpointAppId(): ?string
    {
        return $this->endpointAppId;
    }

    public function getStClientId(): ?string
    {
        return $this->stClientId;
    }

    public function getStClientSecret(): ?string
    {
        return $this->stClientSecret;
    }

    public function setEndpointAppId(?string $value): SchemaAppReceiptInterface
    {
        $this->endpointAppId = $value;

        return $this;
    }

    public function setStClientId(?string $value): SchemaAppReceiptInterface
    {
        $this->stClientId = $value;

        return $this;
    }

    public function setStClientSecret(?string $value): SchemaAppReceiptInterface
    {
        $this->stClientSecret = $value;

        return $this;
    }
}
