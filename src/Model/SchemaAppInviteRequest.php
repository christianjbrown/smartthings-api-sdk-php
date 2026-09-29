<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInviteRequest implements SchemaAppInviteRequestInterface
{
    private ?int $acceptLimit = null;
    private ?string $description = null;
    private ?string $schemaAppId = null;

    public function getAcceptLimit(): ?int
    {
        return $this->acceptLimit;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSchemaAppId(): ?string
    {
        return $this->schemaAppId;
    }

    public function setAcceptLimit(?int $value): SchemaAppInviteRequestInterface
    {
        $this->acceptLimit = $value;

        return $this;
    }

    public function setDescription(?string $value): SchemaAppInviteRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setSchemaAppId(?string $value): SchemaAppInviteRequestInterface
    {
        $this->schemaAppId = $value;

        return $this;
    }
}
