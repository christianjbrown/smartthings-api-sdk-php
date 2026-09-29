<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationIconsItem implements DeviceConfigurationIconsItemInterface
{
    /**
     * @var null|array<int, DeviceConfigurationIconsItemBadgeItemInterface>
     */
    private ?array $badge = null;
    private ?string $group = null;
    private ?string $iconUrl = null;

    /**
     * @var null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface>
     */
    private ?array $productKeys = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $runningConditions = null;

    /**
     * @return null|array<int, DeviceConfigurationIconsItemBadgeItemInterface>
     */
    public function getBadge(): ?array
    {
        return $this->badge;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    /**
     * @return null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface>
     */
    public function getProductKeys(): ?array
    {
        return $this->productKeys;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getRunningConditions(): ?array
    {
        return $this->runningConditions;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemBadgeItemInterface> $value
     */
    public function setBadge(?array $value): DeviceConfigurationIconsItemInterface
    {
        $this->badge = $value;

        return $this;
    }

    public function setGroup(?string $value): DeviceConfigurationIconsItemInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setIconUrl(?string $value): DeviceConfigurationIconsItemInterface
    {
        $this->iconUrl = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceConfigurationIconsItemProductKeysItemInterface> $value
     */
    public function setProductKeys(?array $value): DeviceConfigurationIconsItemInterface
    {
        $this->productKeys = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setRunningConditions(?array $value): DeviceConfigurationIconsItemInterface
    {
        $this->runningConditions = $value;

        return $this;
    }
}
