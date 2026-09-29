<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityCommand implements CapabilityCommandInterface
{
    /**
     * @var null|array<int, CommandArgumentInterface>
     */
    private ?array $arguments = null;
    private string $name;
    private ?bool $sensitive = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|array<int, CommandArgumentInterface>
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSensitive(): ?bool
    {
        return $this->sensitive;
    }

    /**
     * @param null|array<int, CommandArgumentInterface> $value
     */
    public function setArguments(?array $value): CapabilityCommandInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setSensitive(?bool $value): CapabilityCommandInterface
    {
        $this->sensitive = $value;

        return $this;
    }
}
