<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;

interface StatelessPowerToggleForDashboardSerializerInterface
{
    public const string KEY_ARGUMENT = 'argument';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_COMMAND = 'command';

    /**
     * @return mixed[]
     */
    public function serialize(StatelessPowerToggleForDashboardInterface $model): array;
}
