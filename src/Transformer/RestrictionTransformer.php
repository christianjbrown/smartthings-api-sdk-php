<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\Restriction;
use ChristianBrown\SmartThings\Model\RestrictionInterface;

use function is_bool;
use function is_int;

final class RestrictionTransformer implements RestrictionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RestrictionInterface
    {
        $model = new Restriction(self::requireTier($data));

        self::applyHistoryRetentionTTLDays($model, $data);
        self::applyVisibleWhenRestricted($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHistoryRetentionTTLDays(Restriction $model, array $data): void
    {
        if (!isset($data[self::KEY_HISTORY_RETENTION_TTLDAYS])) {
            return;
        }
        if (!is_int($data[self::KEY_HISTORY_RETENTION_TTLDAYS])) {
            return;
        }
        $model->setHistoryRetentionTTLDays($data[self::KEY_HISTORY_RETENTION_TTLDAYS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVisibleWhenRestricted(Restriction $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_WHEN_RESTRICTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_VISIBLE_WHEN_RESTRICTED])) {
            return;
        }
        $model->setVisibleWhenRestricted($data[self::KEY_VISIBLE_WHEN_RESTRICTED]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTier(array $data): ?int
    {
        if (!isset($data[self::KEY_TIER])) {
            return null;
        }
        if (!is_int($data[self::KEY_TIER])) {
            return null;
        }

        return $data[self::KEY_TIER];
    }
}
