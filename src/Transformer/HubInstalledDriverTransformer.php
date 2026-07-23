<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubInstalledDriver;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;

use function is_string;
use function sprintf;

final class HubInstalledDriverTransformer implements HubInstalledDriverTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubInstalledDriverInterface
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        $driver = new HubInstalledDriver($data[self::KEY_DRIVER_ID]);

        self::applyChannelId($driver, $data);
        self::applyDescription($driver, $data);
        self::applyDeveloper($driver, $data);
        self::applyName($driver, $data);
        self::applyVendorSupportInformation($driver, $data);
        self::applyVersion($driver, $data);

        return $driver;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChannelId(HubInstalledDriver $driver, array $data): void
    {
        if (empty($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        $driver->setChannelId($data[self::KEY_CHANNEL_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(HubInstalledDriver $driver, array $data): void
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
    private static function applyDeveloper(HubInstalledDriver $driver, array $data): void
    {
        if (empty($data[self::KEY_DEVELOPER])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVELOPER])) {
            return;
        }
        $driver->setDeveloper($data[self::KEY_DEVELOPER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(HubInstalledDriver $driver, array $data): void
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
    private static function applyVendorSupportInformation(HubInstalledDriver $driver, array $data): void
    {
        if (empty($data[self::KEY_VENDOR_SUPPORT_INFORMATION])) {
            return;
        }
        if (!is_string($data[self::KEY_VENDOR_SUPPORT_INFORMATION])) {
            return;
        }
        $driver->setVendorSupportInformation($data[self::KEY_VENDOR_SUPPORT_INFORMATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(HubInstalledDriver $driver, array $data): void
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
