<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;

interface ExcludedActionItemIdExcludeItemTransformerInterface
{
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_COMMANDS = 'commands';
    public const string KEY_COMPONENT = 'component';
    public const string KEY_VERSION = 'version';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedActionItemIdExcludeItemInterface;
}
