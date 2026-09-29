<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MatterEndpoint implements MatterEndpointInterface
{
    /**
     * @var null|array<int, MatterEndpointDeviceTypeInterface>
     */
    private ?array $deviceTypes = null;
    private ?int $endpointId = null;

    /**
     * @return null|array<int, MatterEndpointDeviceTypeInterface>
     */
    public function getDeviceTypes(): ?array
    {
        return $this->deviceTypes;
    }

    public function getEndpointId(): ?int
    {
        return $this->endpointId;
    }

    /**
     * @param null|array<int, MatterEndpointDeviceTypeInterface> $value
     */
    public function setDeviceTypes(?array $value): MatterEndpointInterface
    {
        $this->deviceTypes = $value;

        return $this;
    }

    public function setEndpointId(?int $value): MatterEndpointInterface
    {
        $this->endpointId = $value;

        return $this;
    }
}
