<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityStatusInterface
{
    /**
     * @return array<array-key, AttributeStateInterface>
     */
    public function getAttributes(): array;

    /**
     * @param array<array-key, AttributeStateInterface> $value
     */
    public function setAttributes(array $value): self;
}
