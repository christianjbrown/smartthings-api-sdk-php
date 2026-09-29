<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;

interface TextFieldForArgumentSerializerInterface
{
    public const string KEY_ARGUMENT_TYPE = 'argumentType';
    public const string KEY_NAME = 'name';
    public const string KEY_RANGE = 'range';

    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForArgumentInterface $model): array;
}
