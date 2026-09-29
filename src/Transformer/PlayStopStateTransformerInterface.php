<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PlayStopStateInterface;

interface PlayStopStateTransformerInterface
{
    public const string KEY_ALTERNATIVES = 'alternatives';
    public const string KEY_PLAY = 'play';
    public const string KEY_STOP = 'stop';
    public const string KEY_VALUE = 'value';
    public const string KEY_VALUE_TYPE = 'valueType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayStopStateInterface;
}
