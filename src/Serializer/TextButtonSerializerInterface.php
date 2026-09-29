<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextButtonInterface;

interface TextButtonSerializerInterface
{
    public const string KEY_BUTTONS = 'buttons';
    public const string KEY_COMMAND = 'command';
    public const string KEY_SUPPORTED_VALUES = 'supportedValues';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(TextButtonInterface $model): array;
}
