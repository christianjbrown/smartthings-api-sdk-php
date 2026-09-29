<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsForDevicePresentationInterface;

interface PresentationSettingsForDevicePresentationTransformerInterface
{
    public const string KEY_TEMPERATURE_CONVERSIONS = 'temperatureConversions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationSettingsForDevicePresentationInterface;
}
