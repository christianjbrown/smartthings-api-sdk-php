<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationDpInfoItemInterface
{
    /**
     * @return null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface>
     */
    public function getArguments(): ?array;

    public function getDpUri(): ?string;

    public function getOperatingMode(): ?string;

    public function getOs(): ?string;

    public function getServerDpUri(): ?string;

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface> $value
     */
    public function setArguments(?array $value): self;

    public function setOperatingMode(?string $value): self;

    public function setServerDpUri(?string $value): self;
}
