<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateCapabilityRequest implements UpdateCapabilityRequestInterface
{
    /**
     * @var null|array<array-key, CapabilityAttributeInterface>
     */
    private ?array $attributes = null;

    /**
     * @var null|array<array-key, CapabilityCommandInterface>
     */
    private ?array $commands = null;

    /**
     * @return null|array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return null|array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
    }

    /**
     * @param null|array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(?array $value): UpdateCapabilityRequestInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(?array $value): UpdateCapabilityRequestInterface
    {
        $this->commands = $value;

        return $this;
    }
}
