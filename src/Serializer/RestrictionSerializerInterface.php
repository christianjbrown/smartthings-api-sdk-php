<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\RestrictionInterface;

interface RestrictionSerializerInterface
{
    public const string KEY_HISTORY_RETENTION_TTLDAYS = 'historyRetentionTTLDays';
    public const string KEY_TIER = 'tier';
    public const string KEY_VISIBLE_WHEN_RESTRICTED = 'visibleWhenRestricted';

    /**
     * @return mixed[]
     */
    public function serialize(RestrictionInterface $model): array;
}
