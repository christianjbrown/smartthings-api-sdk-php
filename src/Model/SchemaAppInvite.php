<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInvite implements SchemaAppInviteInterface
{
    private ?string $acceptUrl = null;
    private ?string $declineUrl = null;
    private ?string $description = null;
    private ?float $expiration = null;
    private ?string $id = null;
    private ?string $schemaAppId = null;
    private ?string $shortCode = null;

    public function getAcceptUrl(): ?string
    {
        return $this->acceptUrl;
    }

    public function getDeclineUrl(): ?string
    {
        return $this->declineUrl;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExpiration(): ?float
    {
        return $this->expiration;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getSchemaAppId(): ?string
    {
        return $this->schemaAppId;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setAcceptUrl(?string $value): SchemaAppInviteInterface
    {
        $this->acceptUrl = $value;

        return $this;
    }

    public function setDeclineUrl(?string $value): SchemaAppInviteInterface
    {
        $this->declineUrl = $value;

        return $this;
    }

    public function setDescription(?string $value): SchemaAppInviteInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setExpiration(?float $value): SchemaAppInviteInterface
    {
        $this->expiration = $value;

        return $this;
    }

    public function setId(?string $value): SchemaAppInviteInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setSchemaAppId(?string $value): SchemaAppInviteInterface
    {
        $this->schemaAppId = $value;

        return $this;
    }

    public function setShortCode(?string $value): SchemaAppInviteInterface
    {
        $this->shortCode = $value;

        return $this;
    }
}
