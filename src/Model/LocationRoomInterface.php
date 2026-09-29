<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationRoomInterface
{
    /**
     * @return array<int, string>
     */
    public function getAllowed(): array;

    public function getBackgroundImage(): ?string;

    public function getCreated(): ?string;

    public function getIndoorMap(): ?RoomIndoorMapInterface;

    public function getLastModified(): ?string;

    public function getLocationId(): ?string;

    public function getName(): ?string;

    public function getRoomId(): string;

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): self;

    public function setBackgroundImage(?string $value): self;

    public function setCreated(?string $value): self;

    public function setIndoorMap(?RoomIndoorMapInterface $value): self;

    public function setLastModified(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setName(?string $value): self;

    public function setRoomId(string $value): self;
}
