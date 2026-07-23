<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;

interface HubEnrolledChannelsTransformerInterface
{
    public const string ARRAY_NAME = 'enrolledChannel';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubEnrolledChannelInterface>
     */
    public function transform(array $data): array;
}
