<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceIntegrationProfileKeyInterface
{
    public function getId(): ?string;

    public function getMajorVersion(): ?int;

    public function setId(?string $value): self;

    public function setMajorVersion(?int $value): self;
}
