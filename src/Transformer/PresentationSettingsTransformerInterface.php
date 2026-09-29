<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;

interface PresentationSettingsTransformerInterface
{
    public const string KEY_TEMPERATURE_CONVERSIONS = 'temperatureConversions';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationSettingsInterface;
}
