<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;

use function array_keys;
use function count;
use function is_array;
use function sprintf;

final class DevicePreferencesTransformer implements DevicePreferencesTransformerInterface
{
    private DevicePreferenceTransformerInterface $devicePreferenceTransformer;

    public function __construct(DevicePreferenceTransformerInterface $devicePreferenceTransformer)
    {
        $this->devicePreferenceTransformer = $devicePreferenceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DevicePreferenceInterface>
     */
    public function transform(array $data): array
    {
        // The device preferences response wraps the values in a name-keyed map,
        // so the preference name is the array key: an empty map is a valid,
        // non-error result, hence the isset/is_array guard rather than empty().
        if (!isset($data[self::KEY_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_VALUES));
        }
        if (!is_array($data[self::KEY_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_VALUES));
        }

        $preferences = [];
        $names = array_keys($data[self::KEY_VALUES]);
        for ($i = 0, $count = count($names); $i < $count; ++$i) {
            $name = $names[$i];
            $preferenceData = $data[self::KEY_VALUES][$name];
            if (!is_array($preferenceData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $preferenceData[DevicePreferenceTransformerInterface::KEY_NAME] = $name;
            $preferences[] = $this->devicePreferenceTransformer->transform($preferenceData);
        }

        return $preferences;
    }
}
