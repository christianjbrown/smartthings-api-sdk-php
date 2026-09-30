<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDriverInterface
{
    public function getChannelId(): ?string;

    public function getDriverId(): ?string;

    public function getDriverVersion(): ?string;

    public function setChannelId(?string $value): self;

    public function setDriverVersion(?string $value): self;
}
