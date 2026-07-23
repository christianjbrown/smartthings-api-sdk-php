<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityNamespace;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;

use function is_string;
use function sprintf;

final class CapabilityNamespaceTransformer implements CapabilityNamespaceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityNamespaceInterface
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        $namespace = new CapabilityNamespace($data[self::KEY_NAME]);

        self::applyOwnerId($namespace, $data);
        self::applyOwnerType($namespace, $data);

        return $namespace;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOwnerId(CapabilityNamespace $namespace, array $data): void
    {
        if (empty($data[self::KEY_OWNER_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER_ID])) {
            return;
        }
        $namespace->setOwnerId($data[self::KEY_OWNER_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOwnerType(CapabilityNamespace $namespace, array $data): void
    {
        if (empty($data[self::KEY_OWNER_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_OWNER_TYPE])) {
            return;
        }
        $namespace->setOwnerType($data[self::KEY_OWNER_TYPE]);
    }
}
