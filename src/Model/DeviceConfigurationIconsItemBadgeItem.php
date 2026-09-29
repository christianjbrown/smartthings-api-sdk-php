<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationIconsItemBadgeItem implements DeviceConfigurationIconsItemBadgeItemInterface
{
    private string $iconUrl;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(string $iconUrl)
    {
        $this->iconUrl = $iconUrl;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): DeviceConfigurationIconsItemBadgeItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
