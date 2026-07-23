<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DriverInterface
{
    public function getDescription(): ?string;

    public function getDriverId(): string;

    public function getName(): ?string;

    public function getPackageKey(): ?string;

    public function getVersion(): ?string;

    public function setDescription(?string $value): self;

    public function setDriverId(string $value): self;

    public function setName(?string $value): self;

    public function setPackageKey(?string $value): self;

    public function setVersion(?string $value): self;
}
