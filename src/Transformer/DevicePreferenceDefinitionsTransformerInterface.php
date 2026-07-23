<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;

interface DevicePreferenceDefinitionsTransformerInterface
{
    public const string ARRAY_NAME = 'devicePreference';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function transform(array $data): array;
}
