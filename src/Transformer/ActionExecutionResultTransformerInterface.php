<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionExecutionResultInterface;

interface ActionExecutionResultTransformerInterface
{
    public const string KEY_ACTION_ID = 'actionId';
    public const string KEY_BEHAVIOR = 'behavior';
    public const string KEY_COMMAND = 'command';
    public const string KEY_IF = 'if';
    public const string KEY_LOCATION = 'location';
    public const string KEY_SLEEP = 'sleep';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionExecutionResultInterface;
}
