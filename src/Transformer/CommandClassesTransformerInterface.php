<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandClassesInterface;

interface CommandClassesTransformerInterface
{
    public const string KEY_CONTROLLED = 'controlled';
    public const string KEY_EITHER = 'either';
    public const string KEY_SUPPORTED = 'supported';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandClassesInterface;
}
