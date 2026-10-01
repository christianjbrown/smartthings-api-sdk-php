<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\Model\ActionSequence;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;

use function is_string;

/**
 * Builds ActionSequenceInterface from its decoded JSON.
 */
final class ActionSequenceNodeTransformer implements ActionSequenceNodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): ActionSequenceInterface
    {
        $model = new ActionSequence();

        self::applyActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyActions(ActionSequence $model, array $data): void
    {
        if (empty($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_string($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($data[self::KEY_ACTIONS]);
    }
}
