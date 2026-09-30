<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationIconsItemProductKeysItem implements DeviceConfigurationIconsItemProductKeysItemInterface
{
    private ?string $mnId;
    private ?string $setupId;

    public function __construct(?string $mnId, ?string $setupId)
    {
        $this->mnId = $mnId;
        $this->setupId = $setupId;
    }

    public function getMnId(): ?string
    {
        return $this->mnId;
    }

    public function getSetupId(): ?string
    {
        return $this->setupId;
    }
}
