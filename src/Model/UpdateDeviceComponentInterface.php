<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateDeviceComponentInterface
{
    /**
     * @return array<int, string>
     */
    public function getCategories(): array;

    public function getIcon(): ?string;

    public function getId(): string;

    public function getLabel(): ?string;

    public function setIcon(?string $value): self;

    public function setLabel(?string $value): self;
}
