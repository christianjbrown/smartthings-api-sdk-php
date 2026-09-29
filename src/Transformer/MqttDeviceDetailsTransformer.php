<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MqttDeviceDetails;
use ChristianBrown\SmartThings\Model\MqttDeviceDetailsInterface;

use function is_bool;
use function is_string;

final class MqttDeviceDetailsTransformer implements MqttDeviceDetailsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MqttDeviceDetailsInterface
    {
        $model = new MqttDeviceDetails();

        self::applyHubId($model, $data);
        self::applyExecutingLocally($model, $data);
        self::applyTransferCandidate($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExecutingLocally(MqttDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_EXECUTING_LOCALLY])) {
            return;
        }
        $model->setExecutingLocally($data[self::KEY_EXECUTING_LOCALLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubId(MqttDeviceDetails $model, array $data): void
    {
        if (empty($data[self::KEY_HUB_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_HUB_ID])) {
            return;
        }
        $model->setHubId($data[self::KEY_HUB_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTransferCandidate(MqttDeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_TRANSFER_CANDIDATE])) {
            return;
        }
        if (!is_bool($data[self::KEY_TRANSFER_CANDIDATE])) {
            return;
        }
        $model->setTransferCandidate($data[self::KEY_TRANSFER_CANDIDATE]);
    }
}
