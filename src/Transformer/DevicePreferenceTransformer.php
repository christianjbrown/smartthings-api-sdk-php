<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreference;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;

use function array_key_exists;
use function is_bool;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class DevicePreferenceTransformer implements DevicePreferenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DevicePreferenceInterface
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        $preference = new DevicePreference($data[self::KEY_NAME]);

        self::applyPreferenceType($preference, $data);
        self::applyValue($preference, $data);

        return $preference;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPreferenceType(DevicePreference $preference, array $data): void
    {
        if (empty($data[self::KEY_PREFERENCE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PREFERENCE_TYPE])) {
            return;
        }
        $preference->setPreferenceType($data[self::KEY_PREFERENCE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(DevicePreference $preference, array $data): void
    {
        if (!array_key_exists(self::KEY_VALUE, $data)) {
            return;
        }
        $value = $data[self::KEY_VALUE];
        if (is_string($value)) {
            $preference->setValue($value);

            return;
        }
        if (is_bool($value)) {
            $preference->setValue($value);

            return;
        }
        if (is_int($value)) {
            $preference->setValue($value);

            return;
        }
        if (is_float($value)) {
            $preference->setValue($value);
        }
    }
}
