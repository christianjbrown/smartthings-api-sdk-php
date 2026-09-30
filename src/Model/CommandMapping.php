<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CommandMapping implements CommandMappingInterface
{
    private ?string $capabilityId;
    private ?string $command;

    /**
     * @var array<int, AttributeValueInterface>
     */
    private array $eventValues;
    private ?int $version;

    /**
     * @phpstan-param array<int, AttributeValueInterface> $eventValues
     */
    public function __construct(?string $capabilityId, ?int $version, ?string $command, array $eventValues)
    {
        $this->capabilityId = $capabilityId;
        $this->version = $version;
        $this->command = $command;
        $this->eventValues = $eventValues;
    }

    public function getCapabilityId(): ?string
    {
        return $this->capabilityId;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return array<int, AttributeValueInterface>
     */
    public function getEventValues(): array
    {
        return $this->eventValues;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }
}
