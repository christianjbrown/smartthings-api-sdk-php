<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ChannelDriverInterface;

interface ChannelDriversTransformerInterface
{
    public const string ARRAY_NAME = 'channelDriver';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChannelDriverInterface>
     */
    public function transform(array $data): array;
}
