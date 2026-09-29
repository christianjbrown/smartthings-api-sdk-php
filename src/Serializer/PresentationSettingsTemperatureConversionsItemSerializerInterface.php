<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;

interface PresentationSettingsTemperatureConversionsItemSerializerInterface
{
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(PresentationSettingsTemperatureConversionsItemInterface $model): array;
}
