<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityDetailsInterface
{
    /**
     * @return null|array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): ?array;

    /**
     * @return null|array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): ?array;

    /**
     * @param null|array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(?array $value): self;

    /**
     * @param null|array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(?array $value): self;
}
