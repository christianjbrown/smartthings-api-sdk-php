<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;

interface CapabilityStatusTransformerInterface
{
    /**
     * @param mixed[] $data The capability's attributes, keyed by attribute name
     */
    public function transform(array $data): CapabilityStatusInterface;
}
