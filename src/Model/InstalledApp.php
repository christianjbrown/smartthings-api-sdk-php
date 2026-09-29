<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledApp implements InstalledAppInterface
{
    /**
     * @var array<int, string>
     */
    private array $allowed = [];
    private ?string $appId = null;

    /**
     * @var array<int, string>
     */
    private array $classifications = [];
    private ?string $createdDate = null;
    private ?string $displayName = null;
    private ?InstalledAppIconImageInterface $iconImage = null;
    private string $installedAppId;
    private ?string $installedAppStatus = null;
    private ?string $installedAppType = null;
    private ?string $lastUpdatedDate = null;
    private ?string $locationId = null;

    /**
     * @var array<int, NoticeInterface>
     */
    private array $notices = [];
    private ?OwnerInterface $owner = null;
    private ?string $principalType = null;
    private ?string $referenceId = null;
    private ?int $restrictionTier = null;
    private ?bool $singleInstance = null;
    private ?InstalledAppUiInterface $ui = null;

    public function __construct(string $installedAppId)
    {
        $this->installedAppId = $installedAppId;
    }

    /**
     * @return array<int, string>
     */
    public function getAllowed(): array
    {
        return $this->allowed;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * @return array<int, string>
     */
    public function getClassifications(): array
    {
        return $this->classifications;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function getIconImage(): ?InstalledAppIconImageInterface
    {
        return $this->iconImage;
    }

    public function getInstalledAppId(): string
    {
        return $this->installedAppId;
    }

    public function getInstalledAppStatus(): ?string
    {
        return $this->installedAppStatus;
    }

    public function getInstalledAppType(): ?string
    {
        return $this->installedAppType;
    }

    public function getLastUpdatedDate(): ?string
    {
        return $this->lastUpdatedDate;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    /**
     * @return array<int, NoticeInterface>
     */
    public function getNotices(): array
    {
        return $this->notices;
    }

    public function getOwner(): ?OwnerInterface
    {
        return $this->owner;
    }

    public function getPrincipalType(): ?string
    {
        return $this->principalType;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function getRestrictionTier(): ?int
    {
        return $this->restrictionTier;
    }

    public function getSingleInstance(): ?bool
    {
        return $this->singleInstance;
    }

    public function getUi(): ?InstalledAppUiInterface
    {
        return $this->ui;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): InstalledAppInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setAppId(?string $value): InstalledAppInterface
    {
        $this->appId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setClassifications(array $value): InstalledAppInterface
    {
        $this->classifications = $value;

        return $this;
    }

    public function setCreatedDate(?string $value): InstalledAppInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setDisplayName(?string $value): InstalledAppInterface
    {
        $this->displayName = $value;

        return $this;
    }

    public function setIconImage(?InstalledAppIconImageInterface $value): InstalledAppInterface
    {
        $this->iconImage = $value;

        return $this;
    }

    public function setInstalledAppId(string $value): InstalledAppInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setInstalledAppStatus(?string $value): InstalledAppInterface
    {
        $this->installedAppStatus = $value;

        return $this;
    }

    public function setInstalledAppType(?string $value): InstalledAppInterface
    {
        $this->installedAppType = $value;

        return $this;
    }

    public function setLastUpdatedDate(?string $value): InstalledAppInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }

    public function setLocationId(?string $value): InstalledAppInterface
    {
        $this->locationId = $value;

        return $this;
    }

    /**
     * @param array<int, NoticeInterface> $value
     */
    public function setNotices(array $value): InstalledAppInterface
    {
        $this->notices = $value;

        return $this;
    }

    public function setOwner(?OwnerInterface $value): InstalledAppInterface
    {
        $this->owner = $value;

        return $this;
    }

    public function setPrincipalType(?string $value): InstalledAppInterface
    {
        $this->principalType = $value;

        return $this;
    }

    public function setReferenceId(?string $value): InstalledAppInterface
    {
        $this->referenceId = $value;

        return $this;
    }

    public function setRestrictionTier(?int $value): InstalledAppInterface
    {
        $this->restrictionTier = $value;

        return $this;
    }

    public function setSingleInstance(?bool $value): InstalledAppInterface
    {
        $this->singleInstance = $value;

        return $this;
    }

    public function setUi(?InstalledAppUiInterface $value): InstalledAppInterface
    {
        $this->ui = $value;

        return $this;
    }
}
