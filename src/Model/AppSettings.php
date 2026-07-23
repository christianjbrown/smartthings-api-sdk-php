<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AppSettings implements AppSettingsInterface
{
    /**
     * @var array<string, string>
     */
    private array $settings = [];

    /**
     * @return array<string, string>
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array<string, string> $value
     */
    public function setSettings(array $value): AppSettingsInterface
    {
        $this->settings = $value;

        return $this;
    }
}
