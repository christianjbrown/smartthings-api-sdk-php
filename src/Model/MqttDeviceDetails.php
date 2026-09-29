<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MqttDeviceDetails implements MqttDeviceDetailsInterface
{
    private ?bool $executingLocally = null;
    private ?string $hubId = null;
    private ?bool $transferCandidate = null;

    public function getExecutingLocally(): ?bool
    {
        return $this->executingLocally;
    }

    public function getHubId(): ?string
    {
        return $this->hubId;
    }

    public function getTransferCandidate(): ?bool
    {
        return $this->transferCandidate;
    }

    public function setExecutingLocally(?bool $value): MqttDeviceDetailsInterface
    {
        $this->executingLocally = $value;

        return $this;
    }

    public function setHubId(?string $value): MqttDeviceDetailsInterface
    {
        $this->hubId = $value;

        return $this;
    }

    public function setTransferCandidate(?bool $value): MqttDeviceDetailsInterface
    {
        $this->transferCandidate = $value;

        return $this;
    }
}
