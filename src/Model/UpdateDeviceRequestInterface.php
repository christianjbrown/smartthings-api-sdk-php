<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateDeviceRequestInterface
{
    public function getLabel(): ?string;

    public function getLocationId(): ?string;

    public function getRoomId(): ?string;

    public function setLabel(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setRoomId(?string $value): self;
}
