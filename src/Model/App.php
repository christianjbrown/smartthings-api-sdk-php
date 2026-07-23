<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class App implements AppInterface
{
    private string $appId;
    private ?string $appName = null;
    private ?string $appType = null;
    private ?string $displayName = null;

    public function __construct(string $appId)
    {
        $this->appId = $appId;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function getAppType(): ?string
    {
        return $this->appType;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setAppId(string $value): AppInterface
    {
        $this->appId = $value;

        return $this;
    }

    public function setAppName(?string $value): AppInterface
    {
        $this->appName = $value;

        return $this;
    }

    public function setAppType(?string $value): AppInterface
    {
        $this->appType = $value;

        return $this;
    }

    public function setDisplayName(?string $value): AppInterface
    {
        $this->displayName = $value;

        return $this;
    }
}
