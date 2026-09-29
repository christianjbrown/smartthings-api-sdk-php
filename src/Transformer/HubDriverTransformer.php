<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDriver;
use ChristianBrown\SmartThings\Model\HubDriverInterface;

use function is_string;
use function sprintf;

final class HubDriverTransformer implements HubDriverTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDriverInterface
    {
        $model = new HubDriver(self::requireDriverId($data));

        self::applyDriverVersion($model, $data);
        self::applyChannelId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChannelId(HubDriver $model, array $data): void
    {
        if (empty($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CHANNEL_ID])) {
            return;
        }
        $model->setChannelId($data[self::KEY_CHANNEL_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDriverVersion(HubDriver $model, array $data): void
    {
        if (empty($data[self::KEY_DRIVER_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_DRIVER_VERSION])) {
            return;
        }
        $model->setDriverVersion($data[self::KEY_DRIVER_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDriverId(array $data): string
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }

        return $data[self::KEY_DRIVER_ID];
    }
}
