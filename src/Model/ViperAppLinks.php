<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ViperAppLinks implements ViperAppLinksInterface
{
    private ?string $android = null;
    private ?string $ios = null;
    private ?bool $isLinkingEnabled = null;

    public function getAndroid(): ?string
    {
        return $this->android;
    }

    public function getIos(): ?string
    {
        return $this->ios;
    }

    public function getIsLinkingEnabled(): ?bool
    {
        return $this->isLinkingEnabled;
    }

    public function setAndroid(?string $value): ViperAppLinksInterface
    {
        $this->android = $value;

        return $this;
    }

    public function setIos(?string $value): ViperAppLinksInterface
    {
        $this->ios = $value;

        return $this;
    }

    public function setIsLinkingEnabled(?bool $value): ViperAppLinksInterface
    {
        $this->isLinkingEnabled = $value;

        return $this;
    }
}
