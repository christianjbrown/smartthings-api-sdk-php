<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityInterface
{
    /**
     * @return array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): array;

    /**
     * @return array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): array;

    public function getEphemeral(): ?bool;

    public function getId(): string;

    public function getName(): ?string;

    public function getStatus(): ?string;

    public function getVersion(): ?int;

    /**
     * @param array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(array $value): self;

    /**
     * @param array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(array $value): self;

    public function setEphemeral(?bool $value): self;

    public function setId(string $value): self;

    public function setName(?string $value): self;

    public function setStatus(?string $value): self;

    public function setVersion(?int $value): self;
}
