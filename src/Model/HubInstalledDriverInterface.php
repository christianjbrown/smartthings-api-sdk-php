<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubInstalledDriverInterface
{
    public function getChannelId(): ?string;

    public function getDescription(): ?string;

    public function getDeveloper(): ?string;

    public function getDriverId(): string;

    public function getName(): ?string;

    public function getVendorSupportInformation(): ?string;

    public function getVersion(): ?string;

    public function setChannelId(?string $value): self;

    public function setDescription(?string $value): self;

    public function setDeveloper(?string $value): self;

    public function setDriverId(string $value): self;

    public function setName(?string $value): self;

    public function setVendorSupportInformation(?string $value): self;

    public function setVersion(?string $value): self;
}
