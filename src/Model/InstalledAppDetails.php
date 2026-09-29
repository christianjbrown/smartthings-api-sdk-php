<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppDetails implements InstalledAppDetailsInterface
{
    private ?InstalledAppIconImageInterface $iconImage = null;

    /**
     * @var null|array<int, NoticeInterface>
     */
    private ?array $notices = null;
    private ?OwnerInterface $owner = null;
    private ?InstalledAppUiInterface $ui = null;

    public function getIconImage(): ?InstalledAppIconImageInterface
    {
        return $this->iconImage;
    }

    /**
     * @return null|array<int, NoticeInterface>
     */
    public function getNotices(): ?array
    {
        return $this->notices;
    }

    public function getOwner(): ?OwnerInterface
    {
        return $this->owner;
    }

    public function getUi(): ?InstalledAppUiInterface
    {
        return $this->ui;
    }

    public function setIconImage(?InstalledAppIconImageInterface $value): InstalledAppDetailsInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    /**
     * @param null|array<int, NoticeInterface> $value
     */
    public function setNotices(?array $value): InstalledAppDetailsInterface
    {
        $this->notices = $value;

        return $this;
    }

    public function setOwner(?OwnerInterface $value): InstalledAppDetailsInterface
    {
        $this->owner = $value;

        return $this;
    }

    public function setUi(?InstalledAppUiInterface $value): InstalledAppDetailsInterface
    {
        $this->ui = $value;

        return $this;
    }
}
