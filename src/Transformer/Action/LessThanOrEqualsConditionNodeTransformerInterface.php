<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\LessThanOrEqualsConditionInterface;

/**
 * @extends NodeTransformerInterface<LessThanOrEqualsConditionInterface>
 */
interface LessThanOrEqualsConditionNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): LessThanOrEqualsConditionInterface;
}
