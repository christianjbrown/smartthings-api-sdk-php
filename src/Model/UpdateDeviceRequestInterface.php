<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateDeviceRequestInterface
{
    /**
     * @return null|array<int, UpdateDeviceComponentInterface>
     */
    public function getComponents(): ?array;

    public function getIndoorMap(): ?IndoorMapInterface;

    public function getLabel(): ?string;

    public function getLocationId(): ?string;

    public function getRoomId(): ?string;

    /**
     * @param null|array<int, UpdateDeviceComponentInterface> $value
     */
    public function setComponents(?array $value): self;

    public function setIndoorMap(?IndoorMapInterface $value): self;

    public function setLabel(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setRoomId(?string $value): self;
}
