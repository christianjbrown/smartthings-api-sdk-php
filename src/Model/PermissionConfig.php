<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PermissionConfig implements PermissionConfigInterface
{
    /**
     * @var array<int, string>
     */
    private array $permissions = [];

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): PermissionConfigInterface
    {
        $this->permissions = $value;

        return $this;
    }
}
