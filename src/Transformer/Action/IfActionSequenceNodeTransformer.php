<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\IfActionSequence;
use ChristianBrown\SmartThings\Model\IfActionSequenceInterface;

use function is_string;

/**
 * Builds IfActionSequenceInterface from its decoded JSON.
 */
final class IfActionSequenceNodeTransformer implements IfActionSequenceNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): IfActionSequenceInterface
    {
        $model = new IfActionSequence();

        self::applyThen($model, $data);
        self::applyElse($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyElse(IfActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_ELSE])) {
            return;
        }
        if (!is_string($data[self::KEY_ELSE])) {
            return;
        }
        $model->setElse($data[self::KEY_ELSE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyThen(IfActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_THEN])) {
            return;
        }
        if (!is_string($data[self::KEY_THEN])) {
            return;
        }
        $model->setThen($data[self::KEY_THEN]);
    }
}
