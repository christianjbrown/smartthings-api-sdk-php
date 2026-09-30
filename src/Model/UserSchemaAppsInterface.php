<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UserSchemaAppsInterface
{
    /**
     * @return array<int, SchemaAppInterface>
     */
    public function getEndpointApps(): array;

    public function getUserId(): ?string;

    /**
     * @param array<int, SchemaAppInterface> $value
     */
    public function setEndpointApps(array $value): self;

    public function setUserId(?string $value): self;
}
