<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ComponentStatus implements ComponentStatusInterface
{
    /**
     * @var array<array-key, CapabilityStatusInterface>
     */
    private array $capabilities = [];

    /**
     * @return array<array-key, CapabilityStatusInterface>
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }

    /**
     * @param array<array-key, CapabilityStatusInterface> $value
     */
    public function setCapabilities(array $value): ComponentStatusInterface
    {
        $this->capabilities = $value;

        return $this;
    }
}
