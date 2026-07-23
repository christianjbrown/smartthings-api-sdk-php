<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ChannelInterface;

interface ChannelsTransformerInterface
{
    public const string ARRAY_NAME = 'channel';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChannelInterface>
     */
    public function transform(array $data): array;
}
