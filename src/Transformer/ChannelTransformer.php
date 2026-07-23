<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Channel;
use ChristianBrown\SmartThings\Model\ChannelInterface;

use function is_string;
use function sprintf;

final class ChannelTransformer implements ChannelTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ChannelInterface
    {
        if (empty($data[self::KEY_CHANNEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CHANNEL_ID));
        }
        if (!is_string($data[self::KEY_CHANNEL_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CHANNEL_ID));
        }
        $channel = new Channel($data[self::KEY_CHANNEL_ID]);

        self::applyDescription($channel, $data);
        self::applyName($channel, $data);
        self::applyTermsOfServiceUrl($channel, $data);
        self::applyType($channel, $data);

        return $channel;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Channel $channel, array $data): void
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
    private static function applyName(Channel $channel, array $data): void
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
    private static function applyTermsOfServiceUrl(Channel $channel, array $data): void
    {
        if (empty($data[self::KEY_TERMS_OF_SERVICE_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TERMS_OF_SERVICE_URL])) {
            return;
        }
        $channel->setTermsOfServiceUrl($data[self::KEY_TERMS_OF_SERVICE_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(Channel $channel, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $channel->setType($data[self::KEY_TYPE]);
    }
}
