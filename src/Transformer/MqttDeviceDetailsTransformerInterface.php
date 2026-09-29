<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MqttDeviceDetailsInterface;

interface MqttDeviceDetailsTransformerInterface
{
    public const string KEY_EXECUTING_LOCALLY = 'executingLocally';
    public const string KEY_HUB_ID = 'hubId';
    public const string KEY_TRANSFER_CANDIDATE = 'transferCandidate';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MqttDeviceDetailsInterface;
}
