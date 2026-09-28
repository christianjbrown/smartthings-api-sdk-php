<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceCommandResultInterface
{
    public function getId(): ?string;

    public function getStatus(): ?string;

    public function setId(?string $value): self;

    public function setStatus(?string $value): self;
}
