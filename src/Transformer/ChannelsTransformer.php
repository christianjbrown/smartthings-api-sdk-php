<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ChannelsTransformer implements ChannelsTransformerInterface
{
    private ChannelTransformerInterface $channelTransformer;

    public function __construct(ChannelTransformerInterface $channelTransformer)
    {
        $this->channelTransformer = $channelTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ChannelInterface>
     */
    public function transform(array $data): array
    {
        $channels = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $channelData = $values[$i];
            if (!is_array($channelData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $channels[] = $this->channelTransformer->transform($channelData);
        }

        return $channels;
    }
}
