<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IconImage implements IconImageInterface
{
    private ?string $url = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $value): IconImageInterface
    {
        $this->url = $value;

        return $this;
    }
}
