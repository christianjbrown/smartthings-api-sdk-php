<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;

interface BasicPlusTvDirectionalPadCommandTransformerInterface
{
    public const string KEY_DOWN = 'down';
    public const string KEY_LEFT = 'left';
    public const string KEY_NAME = 'name';
    public const string KEY_OK = 'ok';
    public const string KEY_RIGHT = 'right';
    public const string KEY_UP = 'up';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvDirectionalPadCommandInterface;
}
