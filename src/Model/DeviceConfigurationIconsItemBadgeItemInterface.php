<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationIconsItemBadgeItemInterface
{
    public function getIconUrl(): ?string;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
