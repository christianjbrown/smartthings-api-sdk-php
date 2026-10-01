<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\SceneSleepRequest;
use ChristianBrown\SmartThings\Model\SceneSleepRequestInterface;

use function is_int;

/**
 * Builds SceneSleepRequestInterface from its decoded JSON.
 */
final class SceneSleepRequestNodeTransformer implements SceneSleepRequestNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneSleepRequestInterface
    {
        $model = new SceneSleepRequest(self::requireSeconds($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSeconds(array $data): ?int
    {
        if (!isset($data[self::KEY_SECONDS])) {
            return null;
        }
        if (!is_int($data[self::KEY_SECONDS])) {
            return null;
        }

        return $data[self::KEY_SECONDS];
    }
}
