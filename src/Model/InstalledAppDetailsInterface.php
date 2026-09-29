<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppDetailsInterface
{
    public function getIconImage(): ?InstalledAppIconImageInterface;

    /**
     * @return null|array<int, NoticeInterface>
     */
    public function getNotices(): ?array;

    public function getOwner(): ?OwnerInterface;

    public function getUi(): ?InstalledAppUiInterface;

    public function setIconImage(?InstalledAppIconImageInterface $value): self;

    /**
     * @param null|array<int, NoticeInterface> $value
     */
    public function setNotices(?array $value): self;

    public function setOwner(?OwnerInterface $value): self;

    public function setUi(?InstalledAppUiInterface $value): self;
}
