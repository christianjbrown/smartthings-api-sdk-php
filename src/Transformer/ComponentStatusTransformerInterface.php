<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ComponentStatusInterface;

interface ComponentStatusTransformerInterface
{
    /**
     * @param mixed[] $data The component's capabilities, keyed by capability id
     */
    public function transform(array $data): ComponentStatusInterface;
}
