<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppInterface
{
    /**
     * @return array<int, string>
     */
    public function getAllowed(): array;

    public function getAppId(): ?string;

    /**
     * @return array<int, string>
     */
    public function getClassifications(): array;

    public function getCreatedDate(): ?string;

    public function getDisplayName(): ?string;

    public function getIconImage(): ?InstalledAppIconImageInterface;

    public function getInstalledAppId(): string;

    public function getInstalledAppStatus(): ?string;

    public function getInstalledAppType(): ?string;

    public function getLastUpdatedDate(): ?string;

    public function getLocationId(): ?string;

    /**
     * @return array<int, NoticeInterface>
     */
    public function getNotices(): array;

    public function getOwner(): ?OwnerInterface;

    public function getPrincipalType(): ?string;

    public function getReferenceId(): ?string;

    public function getRestrictionTier(): ?int;

    public function getSingleInstance(): ?bool;

    public function getUi(): ?InstalledAppUiInterface;

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): self;

    public function setAppId(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setClassifications(array $value): self;

    public function setCreatedDate(?string $value): self;

    public function setDisplayName(?string $value): self;

    public function setIconImage(?InstalledAppIconImageInterface $value): self;

    public function setInstalledAppId(string $value): self;

    public function setInstalledAppStatus(?string $value): self;

    public function setInstalledAppType(?string $value): self;

    public function setLastUpdatedDate(?string $value): self;

    public function setLocationId(?string $value): self;

    /**
     * @param array<int, NoticeInterface> $value
     */
    public function setNotices(array $value): self;

    public function setOwner(?OwnerInterface $value): self;

    public function setPrincipalType(?string $value): self;

    public function setReferenceId(?string $value): self;

    public function setRestrictionTier(?int $value): self;

    public function setSingleInstance(?bool $value): self;

    public function setUi(?InstalledAppUiInterface $value): self;
}
