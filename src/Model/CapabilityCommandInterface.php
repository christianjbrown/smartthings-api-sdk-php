<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityCommandInterface
{
    /**
     * @return null|array<int, CommandArgumentInterface>
     */
    public function getArguments(): ?array;

    public function getName(): ?string;

    public function getSensitive(): ?bool;

    /**
     * @param null|array<int, CommandArgumentInterface> $value
     */
    public function setArguments(?array $value): self;

    public function setSensitive(?bool $value): self;
}
