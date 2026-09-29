<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MatterEndpointInterface
{
    /**
     * @return null|array<int, MatterEndpointDeviceTypeInterface>
     */
    public function getDeviceTypes(): ?array;

    public function getEndpointId(): ?int;

    /**
     * @param null|array<int, MatterEndpointDeviceTypeInterface> $value
     */
    public function setDeviceTypes(?array $value): self;

    public function setEndpointId(?int $value): self;
}
