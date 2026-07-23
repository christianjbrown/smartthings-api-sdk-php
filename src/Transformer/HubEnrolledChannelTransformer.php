<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannel;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;

use function is_string;
use function sprintf;

final class HubEnrolledChannelTransformer implements HubEnrolledChannelTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubEnrolledChannelInterface
    {
        if (empty($data[self::KEY_CHANNEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CHANNEL_ID));
        }
        if (!is_string($data[self::KEY_CHANNEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CHANNEL_ID));
        }
        $channel = new HubEnrolledChannel($data[self::KEY_CHANNEL_ID]);

        self::applyDescription($channel, $data);
        self::applyName($channel, $data);
        self::applySubscriptionUrl($channel, $data);

        return $channel;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(HubEnrolledChannel $channel, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $channel->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(HubEnrolledChannel $channel, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $channel->setName($data[self::KEY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubscriptionUrl(HubEnrolledChannel $channel, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTION_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBSCRIPTION_URL])) {
            return;
        }
        $channel->setSubscriptionUrl($data[self::KEY_SUBSCRIPTION_URL]);
    }
}
