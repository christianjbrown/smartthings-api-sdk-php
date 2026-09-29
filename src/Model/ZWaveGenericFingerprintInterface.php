<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ZWaveGenericFingerprintInterface
{
    public function getCommandClasses(): ?CommandClassesInterface;

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface;

    public function getGenericType(): ?int;

    /**
     * @return null|array<int, int>
     */
    public function getSpecificType(): ?array;

    public function setCommandClasses(?CommandClassesInterface $value): self;

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): self;

    public function setGenericType(?int $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setSpecificType(?array $value): self;
}
