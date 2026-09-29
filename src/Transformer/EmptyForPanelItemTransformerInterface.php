<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EmptyForPanelItemInterface;

interface EmptyForPanelItemTransformerInterface
{
    public const string KEY_SIZE = 'size';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EmptyForPanelItemInterface;
}
