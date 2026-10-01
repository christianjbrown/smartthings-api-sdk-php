<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\CommandSequenceInterface;

/**
 * @extends NodeTransformerInterface<CommandSequenceInterface>
 */
interface CommandSequenceNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): CommandSequenceInterface;
}
