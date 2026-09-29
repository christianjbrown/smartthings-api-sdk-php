<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Driver;
use ChristianBrown\SmartThings\Model\DriverDetailsInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;

use function array_flip;
use function array_intersect_key;
use function is_string;
use function sprintf;

final class DriverTransformer implements DriverTransformerInterface
{
    private DriverDetailsTransformerInterface $driverDetailsTransformer;

    public function __construct(DriverDetailsTransformerInterface $driverDetailsTransformer)
    {
        $this->driverDetailsTransformer = $driverDetailsTransformer;
    }

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

        $this->applyDetails($driver, $data);

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
    private function applyDetails(Driver $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->driverDetailsTransformer->transform($data);
        self::copyDeviceIntegrationProfiles($model, $details);
        self::copyPermissions($model, $details);
        self::copyFingerprints($model, $details);
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

    private static function copyDeviceIntegrationProfiles(Driver $model, DriverDetailsInterface $details): void
    {
        $model->setDeviceIntegrationProfiles($details->getDeviceIntegrationProfiles() ?? []);
    }

    private static function copyFingerprints(Driver $model, DriverDetailsInterface $details): void
    {
        $model->setFingerprints($details->getFingerprints() ?? []);
    }

    private static function copyPermissions(Driver $model, DriverDetailsInterface $details): void
    {
        $model->setPermissions($details->getPermissions() ?? []);
    }
}
