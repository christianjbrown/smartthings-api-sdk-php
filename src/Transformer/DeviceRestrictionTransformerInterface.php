<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceRestrictionInterface;

interface DeviceRestrictionTransformerInterface
{
    public const string KEY_HISTORY_RETENTION_TTLDAYS = 'historyRetentionTTLDays';
    public const string KEY_TIER = 'tier';
    public const string KEY_VISIBLE_WHEN_RESTRICTED = 'visibleWhenRestricted';
    public const string UNEXPECTED_INT_SPRINTF = '%s not set or not an integer';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceRestrictionInterface;
}
