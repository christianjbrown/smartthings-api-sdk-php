<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneCapabilityInterface
{
    public function getCapabilityId(): ?string;

    /**
     * @return null|array<array-key, SceneCommandInterface>
     */
    public function getCommands(): ?array;

    public function getStatus(): ?string;

    public function setCapabilityId(?string $value): self;

    /**
     * @param null|array<array-key, SceneCommandInterface> $value
     */
    public function setCommands(?array $value): self;

    public function setStatus(?string $value): self;
}
