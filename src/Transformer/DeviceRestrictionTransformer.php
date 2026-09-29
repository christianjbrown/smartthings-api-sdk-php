<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceRestriction;
use ChristianBrown\SmartThings\Model\DeviceRestrictionInterface;

use function is_bool;
use function is_int;
use function sprintf;

final class DeviceRestrictionTransformer implements DeviceRestrictionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceRestrictionInterface
    {
        $model = new DeviceRestriction(self::requireTier($data));

        self::applyHistoryRetentionTTLDays($model, $data);
        self::applyVisibleWhenRestricted($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHistoryRetentionTTLDays(DeviceRestriction $model, array $data): void
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
    private static function applyVisibleWhenRestricted(DeviceRestriction $model, array $data): void
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
    private static function requireTier(array $data): int
    {
        if (!isset($data[self::KEY_TIER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_TIER));
        }
        if (!is_int($data[self::KEY_TIER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_INT_SPRINTF, self::KEY_TIER));
        }

        return $data[self::KEY_TIER];
    }
}
