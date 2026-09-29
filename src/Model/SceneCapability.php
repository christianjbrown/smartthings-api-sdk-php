<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneCapability implements SceneCapabilityInterface
{
    private ?string $capabilityId = null;

    /**
     * @var null|array<array-key, SceneCommandInterface>
     */
    private ?array $commands = null;
    private ?string $status = null;

    public function getCapabilityId(): ?string
    {
        return $this->capabilityId;
    }

    /**
     * @return null|array<array-key, SceneCommandInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setCapabilityId(?string $value): SceneCapabilityInterface
    {
        $this->capabilityId = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, SceneCommandInterface> $value
     */
    public function setCommands(?array $value): SceneCapabilityInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setStatus(?string $value): SceneCapabilityInterface
    {
        $this->status = $value;

        return $this;
    }
}
