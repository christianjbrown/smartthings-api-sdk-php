<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInviteAcceptance implements SchemaAppInviteAcceptanceInterface
{
    private ?string $schemaAppId = null;

    public function getSchemaAppId(): ?string
    {
        return $this->schemaAppId;
    }

    public function setSchemaAppId(?string $value): SchemaAppInviteAcceptanceInterface
    {
        $this->schemaAppId = $value;

        return $this;
    }
}
