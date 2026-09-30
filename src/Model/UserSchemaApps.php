<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UserSchemaApps implements UserSchemaAppsInterface
{
    /**
     * @var array<int, SchemaAppInterface>
     */
    private array $endpointApps = [];
    private ?string $userId = null;

    /**
     * @return array<int, SchemaAppInterface>
     */
    public function getEndpointApps(): array
    {
        return $this->endpointApps;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    /**
     * @param array<int, SchemaAppInterface> $value
     */
    public function setEndpointApps(array $value): UserSchemaAppsInterface
    {
        $this->endpointApps = $value;

        return $this;
    }

    public function setUserId(?string $value): UserSchemaAppsInterface
    {
        $this->userId = $value;

        return $this;
    }
}
