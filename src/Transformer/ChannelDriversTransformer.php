<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ChannelDriversTransformer implements ChannelDriversTransformerInterface
{
    private ChannelDriverTransformerInterface $channelDriverTransformer;

    public function __construct(ChannelDriverTransformerInterface $channelDriverTransformer)
    {
        $this->channelDriverTransformer = $channelDriverTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChannelDriverInterface>
     */
    public function transform(array $data): array
    {
        $channelDrivers = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $channelDriverData = $values[$i];
            if (!is_array($channelDriverData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $channelDrivers[] = $this->channelDriverTransformer->transform($channelDriverData);
        }

        return $channelDrivers;
    }
}
