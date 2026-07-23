<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class HubEnrolledChannelsTransformer implements HubEnrolledChannelsTransformerInterface
{
    private HubEnrolledChannelTransformerInterface $hubEnrolledChannelTransformer;

    public function __construct(HubEnrolledChannelTransformerInterface $hubEnrolledChannelTransformer)
    {
        $this->hubEnrolledChannelTransformer = $hubEnrolledChannelTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubEnrolledChannelInterface>
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
            $channels[] = $this->hubEnrolledChannelTransformer->transform($channelData);
        }

        return $channels;
    }
}
