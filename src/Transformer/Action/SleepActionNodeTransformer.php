<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\IntervalInterface;
use ChristianBrown\SmartThings\Model\SleepAction;
use ChristianBrown\SmartThings\Model\SleepActionInterface;

use function is_array;

/**
 * Builds SleepActionInterface from its decoded JSON.
 */
final class SleepActionNodeTransformer implements SleepActionNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SleepActionInterface
    {
        $model = new SleepAction(self::requireDuration($data, $registry));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDuration(array $data, NodeTransformerRegistryInterface $registry): ?IntervalInterface
    {
        if (!isset($data[self::KEY_DURATION])) {
            return null;
        }
        if (!is_array($data[self::KEY_DURATION])) {
            return null;
        }

        return $registry->get(IntervalInterface::class)->transform($data[self::KEY_DURATION], $registry);
    }
}
