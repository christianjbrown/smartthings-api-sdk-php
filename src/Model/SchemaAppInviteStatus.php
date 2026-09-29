<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInviteStatus implements SchemaAppInviteStatusInterface
{
    private ?string $description = null;
    private ?float $expiration = null;
    private ?bool $isAccepted = null;
    private ?string $schemaAppId = null;
    private ?string $shortCode = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExpiration(): ?float
    {
        return $this->expiration;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function getSchemaAppId(): ?string
    {
        return $this->schemaAppId;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setDescription(?string $value): SchemaAppInviteStatusInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setExpiration(?float $value): SchemaAppInviteStatusInterface
    {
        $this->expiration = $value;

        return $this;
    }

    public function setIsAccepted(?bool $value): SchemaAppInviteStatusInterface
    {
        $this->isAccepted = $value;

        return $this;
    }

    public function setSchemaAppId(?string $value): SchemaAppInviteStatusInterface
    {
        $this->schemaAppId = $value;

        return $this;
    }

    public function setShortCode(?string $value): SchemaAppInviteStatusInterface
    {
        $this->shortCode = $value;

        return $this;
    }
}
