<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppDeviceDetails;
use ChristianBrown\SmartThings\Model\AppDeviceDetailsInterface;

use function is_array;
use function is_string;

final class AppDeviceDetailsTransformer implements AppDeviceDetailsTransformerInterface
{
    private DeviceProfileReferenceTransformerInterface $deviceProfileReferenceTransformer;

    public function __construct(DeviceProfileReferenceTransformerInterface $deviceProfileReferenceTransformer)
    {
        $this->deviceProfileReferenceTransformer = $deviceProfileReferenceTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppDeviceDetailsInterface
    {
        $model = new AppDeviceDetails();

        self::applyInstalledAppId($model, $data);
        self::applyExternalId($model, $data);
        $this->applyProfile($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExternalId(AppDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_EXTERNAL_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_EXTERNAL_ID])) {
            return;
        }
        $model->setExternalId($data[self::KEY_EXTERNAL_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInstalledAppId(AppDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INSTALLED_APP_ID])) {
            return;
        }
        $model->setInstalledAppId($data[self::KEY_INSTALLED_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProfile(AppDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PROFILE])) {
            return;
        }
        if (!is_array($data[self::KEY_PROFILE])) {
            return;
        }
        $model->setProfile($this->deviceProfileReferenceTransformer->transform($data[self::KEY_PROFILE]));
    }
}
