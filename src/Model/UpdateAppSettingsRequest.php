<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class UpdateAppSettingsRequest implements UpdateAppSettingsRequestInterface
{
    /**
     * @var null|array<string, string>
     */
    private ?array $settings = null;

    /**
     * @return null|array<string, string>
     */
    public function getSettings(): ?array
    {
        return $this->settings;
    }

    /**
     * @param null|array<string, string> $value
     */
    public function setSettings(?array $value): UpdateAppSettingsRequestInterface
    {
        $this->settings = $value;

        return $this;
    }
}
