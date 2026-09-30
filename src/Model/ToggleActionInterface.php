<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ToggleActionInterface
{
    public function getAttribute(): ?string;

    public function getCapability(): ?string;

    public function getComponent(): ?string;

    /**
     * @return array<int, string>
     */
    public function getDevices(): array;
}
