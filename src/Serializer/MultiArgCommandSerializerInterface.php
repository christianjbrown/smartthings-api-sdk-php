<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;

interface MultiArgCommandSerializerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_COMMAND = 'command';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';

    /**
     * @return mixed[]
     */
    public function serialize(MultiArgCommandInterface $model): array;
}
