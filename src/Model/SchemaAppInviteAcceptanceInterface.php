<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInviteAcceptanceInterface
{
    public function getSchemaAppId(): ?string;

    public function setSchemaAppId(?string $value): self;
}
