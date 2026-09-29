<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfile;
use ChristianBrown\SmartThings\Model\DeviceProfileDetailsInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

use function array_filter;
use function array_flip;
use function array_intersect_key;
use function is_array;
use function is_string;
use function sprintf;

final class DeviceProfileTransformer implements DeviceProfileTransformerInterface
{
    private DeviceProfileDetailsTransformerInterface $deviceProfileDetailsTransformer;

    public function __construct(DeviceProfileDetailsTransformerInterface $deviceProfileDetailsTransformer)
    {
        $this->deviceProfileDetailsTransformer = $deviceProfileDetailsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $profile = new DeviceProfile($data[self::KEY_ID]);

        self::applyName($profile, $data);
        self::applyStatus($profile, $data);

        self::applyMetadata($profile, $data);
        self::applyPresentationId($profile, $data);
        self::applyMigrationStatus($profile, $data);

        $this->applyDetails($profile, $data);

        return $profile;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(DeviceProfile $model, array $data): void
    {
        if ([] === array_intersect_key($data, array_flip(self::DETAIL_KEYS))) {
            return;
        }
        $details = $this->deviceProfileDetailsTransformer->transform($data);
        self::copyRestrictions($model, $details);
        self::copyPreferences($model, $details);
        self::copyComponents($model, $details);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMetadata(DeviceProfile $model, array $data): void
    {
        if (!isset($data[self::KEY_METADATA])) {
            return;
        }
        if (!is_array($data[self::KEY_METADATA])) {
            return;
        }
        $model->setMetadata(array_filter($data[self::KEY_METADATA], is_string(...)));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMigrationStatus(DeviceProfile $model, array $data): void
    {
        if (empty($data[self::KEY_MIGRATION_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_MIGRATION_STATUS])) {
            return;
        }
        $model->setMigrationStatus($data[self::KEY_MIGRATION_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(DeviceProfile $profile, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $profile->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPresentationId(DeviceProfile $model, array $data): void
    {
        if (empty($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PRESENTATION_ID])) {
            return;
        }
        $model->setPresentationId($data[self::KEY_PRESENTATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStatus(DeviceProfile $profile, array $data): void
    {
        if (empty($data[self::KEY_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_STATUS])) {
            return;
        }
        $profile->setStatus($data[self::KEY_STATUS]);
    }

    private static function copyComponents(DeviceProfile $model, DeviceProfileDetailsInterface $details): void
    {
        $model->setComponents($details->getComponents() ?? []);
    }

    private static function copyPreferences(DeviceProfile $model, DeviceProfileDetailsInterface $details): void
    {
        $model->setPreferences($details->getPreferences() ?? []);
    }

    private static function copyRestrictions(DeviceProfile $model, DeviceProfileDetailsInterface $details): void
    {
        $model->setRestrictions($details->getRestrictions());
    }
}
