<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ToggleSwitchInterface;

interface ToggleSwitchTransformerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_STATE = 'state';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ToggleSwitchInterface;
}
