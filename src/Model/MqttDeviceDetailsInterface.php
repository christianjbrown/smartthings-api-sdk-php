<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MqttDeviceDetailsInterface
{
    public function getExecutingLocally(): ?bool;

    public function getHubId(): ?string;

    public function getTransferCandidate(): ?bool;

    public function setExecutingLocally(?bool $value): self;

    public function setHubId(?string $value): self;

    public function setTransferCandidate(?bool $value): self;
}
