<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppIconImage implements InstalledAppIconImageInterface
{
    private ?string $url = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $value): InstalledAppIconImageInterface
    {
        $this->url = $value;

        return $this;
    }
}
