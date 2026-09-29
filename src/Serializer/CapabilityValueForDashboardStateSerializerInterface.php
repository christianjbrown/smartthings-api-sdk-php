<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityValueForDashboardStateInterface;

interface CapabilityValueForDashboardStateSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_LABEL = 'label';

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityValueForDashboardStateInterface $model): array;
}
