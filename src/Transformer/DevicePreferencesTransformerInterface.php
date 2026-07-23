<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;

interface DevicePreferencesTransformerInterface
{
    public const string ARRAY_NAME = 'preference';
    public const string KEY_VALUES = 'values';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DevicePreferenceInterface>
     */
    public function transform(array $data): array;
}
