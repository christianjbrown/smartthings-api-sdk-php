<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateCapabilityRequestInterface
{
    /**
     * @return null|array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): ?array;

    /**
     * @return null|array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): ?array;

    public function getEphemeral(): ?bool;

    public function getName(): string;

    /**
     * @param null|array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(?array $value): self;

    /**
     * @param null|array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(?array $value): self;

    public function setEphemeral(?bool $value): self;
}
