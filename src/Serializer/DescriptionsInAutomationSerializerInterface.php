<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;

interface DescriptionsInAutomationSerializerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_CONDITIONS = 'conditions';

    /**
     * @return mixed[]
     */
    public function serialize(DescriptionsInAutomationInterface $model): array;
}
