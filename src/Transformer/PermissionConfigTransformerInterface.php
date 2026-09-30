<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PermissionConfigInterface;

interface PermissionConfigTransformerInterface
{
    public const string KEY_PERMISSIONS = 'permissions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PermissionConfigInterface;
}
