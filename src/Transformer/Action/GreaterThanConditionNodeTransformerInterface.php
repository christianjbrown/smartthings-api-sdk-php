<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;

/**
 * @extends NodeTransformerInterface<GreaterThanConditionInterface>
 */
interface GreaterThanConditionNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): GreaterThanConditionInterface;
}
