<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CommandActionExecutionResultInterface;

interface CommandActionExecutionResultTransformerInterface
{
    public const string KEY_ARGUMENTS = 'arguments';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMAND = 'command';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_RESULT = 'result';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CommandActionExecutionResultInterface;
}
