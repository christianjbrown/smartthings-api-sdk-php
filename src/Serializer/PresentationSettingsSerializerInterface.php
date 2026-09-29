<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;

interface PresentationSettingsSerializerInterface
{
    public const string KEY_TEMPERATURE_CONVERSIONS = 'temperatureConversions';

    /**
     * @return mixed[]
     */
    public function serialize(PresentationSettingsInterface $model): array;
}
