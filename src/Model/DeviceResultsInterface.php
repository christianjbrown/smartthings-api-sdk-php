<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceResultsInterface
{
    public function getDeviceId(): ?string;

    public function getName(): ?string;

    public function setDeviceId(?string $value): self;

    public function setName(?string $value): self;
}
