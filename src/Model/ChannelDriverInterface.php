<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ChannelDriverInterface
{
    public function getChannelId(): ?string;

    public function getCreatedDate(): ?string;

    public function getDriverId(): string;

    public function getLastModifiedDate(): ?string;

    public function getVersion(): ?string;

    public function setChannelId(?string $value): self;

    public function setCreatedDate(?string $value): self;

    public function setDriverId(string $value): self;

    public function setLastModifiedDate(?string $value): self;

    public function setVersion(?string $value): self;
}
