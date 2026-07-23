<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Driver;
use ChristianBrown\SmartThings\Model\DriverInterface;

use function is_string;
use function sprintf;

final class DriverTransformer implements DriverTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverInterface
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        $driver = new Driver($data[self::KEY_DRIVER_ID]);

        self::applyDescription($driver, $data);
        self::applyName($driver, $data);
        self::applyPackageKey($driver, $data);
        self::applyVersion($driver, $data);

        return $driver;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Driver $driver, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $driver->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Driver $driver, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $driver->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPackageKey(Driver $driver, array $data): void
    {
        if (empty($data[self::KEY_PACKAGE_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_PACKAGE_KEY])) {
            return;
        }
        $driver->setPackageKey($data[self::KEY_PACKAGE_KEY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(Driver $driver, array $data): void
    {
        if (empty($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_VERSION])) {
            return;
        }
        $driver->setVersion($data[self::KEY_VERSION]);
    }
}
