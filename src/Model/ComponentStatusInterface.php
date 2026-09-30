<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ComponentStatusInterface
{
    /**
     * @return array<array-key, CapabilityStatusInterface>
     */
    public function getCapabilities(): array;

    /**
     * @param array<array-key, CapabilityStatusInterface> $value
     */
    public function setCapabilities(array $value): self;
}
