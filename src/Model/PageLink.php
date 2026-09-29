<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PageLink implements PageLinkInterface
{
    private ?string $href = null;

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function setHref(?string $value): PageLinkInterface
    {
        $this->href = $value;

        return $this;
    }
}
