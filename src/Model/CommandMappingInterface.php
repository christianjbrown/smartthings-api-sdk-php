<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandMappingInterface
{
    public function getCapabilityId(): ?string;

    public function getCommand(): ?string;

    /**
     * @return array<int, AttributeValueInterface>
     */
    public function getEventValues(): array;

    public function getVersion(): ?int;
}
