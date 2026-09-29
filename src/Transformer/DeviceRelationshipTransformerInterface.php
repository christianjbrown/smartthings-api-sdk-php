<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceRelationshipInterface;

interface DeviceRelationshipTransformerInterface
{
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_ON_DELETE = 'onDelete';
    public const string KEY_ON_LOCATION_MOVE = 'onLocationMove';
    public const string KEY_ON_OWNERSHIP_TRANSFER = 'onOwnershipTransfer';
    public const string KEY_RELATIONSHIP_TYPE = 'relationshipType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceRelationshipInterface;
}
