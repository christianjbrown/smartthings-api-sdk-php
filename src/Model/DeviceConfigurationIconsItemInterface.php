<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationIconsItemInterface
{
    /**
     * @return null|array<int, DeviceConfigurationIconsItemBadgeItemInterface>
     */
    public function getBadge(): ?array;

    public function getGroup(): ?string;

    public function getIconUrl(): ?string;

    /**
     * @return null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface>
     */
    public function getProductKeys(): ?array;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getRunningConditions(): ?array;

    /**
     * @param null|array<int, DeviceConfigurationIconsItemBadgeItemInterface> $value
     */
    public function setBadge(?array $value): self;

    public function setGroup(?string $value): self;

    public function setIconUrl(?string $value): self;

    /**
     * @param null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface> $value
     */
    public function setProductKeys(?array $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setRunningConditions(?array $value): self;
}
