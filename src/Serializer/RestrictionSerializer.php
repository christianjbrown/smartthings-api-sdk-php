<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\RestrictionInterface;

use function array_filter;

final class RestrictionSerializer implements RestrictionSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(RestrictionInterface $model): array
    {
        $serialized = [
            self::KEY_TIER => $model->getTier(),
            self::KEY_HISTORY_RETENTION_TTLDAYS => $model->getHistoryRetentionTTLDays(),
            self::KEY_VISIBLE_WHEN_RESTRICTED => $model->getVisibleWhenRestricted(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
