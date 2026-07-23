<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfile;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

use function is_string;
use function sprintf;

final class DeviceProfileTransformer implements DeviceProfileTransformerInterface
{
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

        return $profile;
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
}
