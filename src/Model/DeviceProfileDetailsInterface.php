<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceProfileDetailsInterface
{
    /**
     * @return null|array<int, DeviceProfileComponentInterface>
     */
    public function getComponents(): ?array;

    /**
     * @return null|array<int, DevicePreferenceDefinitionInterface>
     */
    public function getPreferences(): ?array;

    public function getRestrictions(): ?DeviceRestrictionInterface;

    /**
     * @param null|array<int, DeviceProfileComponentInterface> $value
     */
    public function setComponents(?array $value): self;

    /**
     * @param null|array<int, DevicePreferenceDefinitionInterface> $value
     */
    public function setPreferences(?array $value): self;

    public function setRestrictions(?DeviceRestrictionInterface $value): self;
}
