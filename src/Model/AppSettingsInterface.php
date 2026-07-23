<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AppSettingsInterface
{
    /**
     * @return array<string, string>
     */
    public function getSettings(): array;

    /**
     * @param array<string, string> $value
     */
    public function setSettings(array $value): self;
}
