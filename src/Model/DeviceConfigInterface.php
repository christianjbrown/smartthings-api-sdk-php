<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigInterface
{
    public function getComponentId(): ?string;

    public function getDeviceId(): ?string;

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array;

    public function setComponentId(?string $value): self;

    public function setDeviceId(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): self;
}
