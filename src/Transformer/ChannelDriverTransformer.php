<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelDriver;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;

use function is_string;
use function sprintf;

final class ChannelDriverTransformer implements ChannelDriverTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ChannelDriverInterface
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        $channelDriver = new ChannelDriver($data[self::KEY_DRIVER_ID]);

        self::applyChannelId($channelDriver, $data);
        self::applyVersion($channelDriver, $data);

        self::applyCreatedDate($channelDriver, $data);
        self::applyLastModifiedDate($channelDriver, $data);

        return $channelDriver;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChannelId(ChannelDriver $channelDriver, array $data): void
    {
        if (empty($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        $channelDriver->setChannelId($data[self::KEY_CHANNEL_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCreatedDate(ChannelDriver $model, array $data): void
    {
        if (empty($data[self::KEY_CREATED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_CREATED_DATE])) {
            return;
        }
        $model->setCreatedDate($data[self::KEY_CREATED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLastModifiedDate(ChannelDriver $model, array $data): void
    {
        if (empty($data[self::KEY_LAST_MODIFIED_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_LAST_MODIFIED_DATE])) {
            return;
        }
        $model->setLastModifiedDate($data[self::KEY_LAST_MODIFIED_DATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ChannelDriver $channelDriver, array $data): void
    {
        if (empty($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_VERSION])) {
            return;
        }
        $channelDriver->setVersion($data[self::KEY_VERSION]);
    }
}
