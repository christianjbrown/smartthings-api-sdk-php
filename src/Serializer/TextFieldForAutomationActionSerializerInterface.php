<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;

interface TextFieldForAutomationActionSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_COMMAND = 'command';
    public const string KEY_RANGE = 'range';

    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForAutomationActionInterface $model): array;
}
