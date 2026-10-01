<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\Interval;
use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\OperandInterface;

use function is_array;
use function is_string;

/**
 * Builds IntervalInterface from its decoded JSON.
 */
final class IntervalNodeTransformer implements IntervalNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): IntervalInterface
    {
        $model = new Interval(self::requireValue($data, $registry), self::requireUnit($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireUnit(array $data): ?string
    {
        if (empty($data[self::KEY_UNIT])) {
            return null;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return null;
        }

        return $data[self::KEY_UNIT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data, NodeTransformerRegistryInterface $registry): ?OperandInterface
    {
        if (!isset($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return null;
        }

        return $registry->get(OperandInterface::class)->transform($data[self::KEY_VALUE], $registry);
    }
}
