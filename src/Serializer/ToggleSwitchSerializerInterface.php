<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchInterface;

interface ToggleSwitchSerializerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_STATE = 'state';

    /**
     * @return mixed[]
     */
    public function serialize(ToggleSwitchInterface $model): array;
}
