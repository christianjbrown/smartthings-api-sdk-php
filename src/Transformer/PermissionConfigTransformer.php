<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PermissionConfig;
use ChristianBrown\SmartThings\Model\PermissionConfigInterface;

final class PermissionConfigTransformer implements PermissionConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PermissionConfigInterface
    {
        return (new PermissionConfig())
            ->setPermissions($this->valueReader->strings($data, self::KEY_PERMISSIONS));
    }
}
