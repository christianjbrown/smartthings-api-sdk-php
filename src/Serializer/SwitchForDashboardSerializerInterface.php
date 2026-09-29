<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SwitchForDashboardInterface;

interface SwitchForDashboardSerializerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_STATE = 'state';

    /**
     * @return mixed[]
     */
    public function serialize(SwitchForDashboardInterface $model): array;
}
