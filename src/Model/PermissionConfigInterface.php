<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PermissionConfigInterface
{
    /**
     * @return array<int, string>
     */
    public function getPermissions(): array;

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): self;
}
