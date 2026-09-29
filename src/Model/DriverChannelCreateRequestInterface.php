<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverChannelCreateRequestInterface
{
    public function getDriverId(): ?string;

    public function getVersion(): ?string;

    public function setDriverId(?string $value): self;

    public function setVersion(?string $value): self;
}
