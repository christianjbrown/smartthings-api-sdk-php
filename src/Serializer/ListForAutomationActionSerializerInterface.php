<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListForAutomationActionInterface;

interface ListForAutomationActionSerializerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_COMMAND = 'command';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';

    /**
     * @return mixed[]
     */
    public function serialize(ListForAutomationActionInterface $model): array;
}
