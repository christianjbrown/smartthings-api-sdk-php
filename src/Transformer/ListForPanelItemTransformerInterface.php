<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ListForPanelItemInterface;

interface ListForPanelItemTransformerInterface
{
    public const string KEY_COMMAND = 'command';
    public const string KEY_SIZE = 'size';
    public const string KEY_STATE = 'state';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ListForPanelItemInterface;
}
