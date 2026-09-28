<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface UpdateAppSettingsRequestInterface
{
    /**
     * @return null|array<string, string>
     */
    public function getSettings(): ?array;

    /**
     * @param null|array<string, string> $value
     */
    public function setSettings(?array $value): self;
}
