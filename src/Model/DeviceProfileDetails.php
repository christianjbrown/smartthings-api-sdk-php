<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceProfileDetails implements DeviceProfileDetailsInterface
{
    /**
     * @var null|array<int, DeviceProfileComponentInterface>
     */
    private ?array $components = null;

    /**
     * @var null|array<int, DevicePreferenceDefinitionInterface>
     */
    private ?array $preferences = null;
    private ?DeviceRestrictionInterface $restrictions = null;

    /**
     * @return null|array<int, DeviceProfileComponentInterface>
     */
    public function getComponents(): ?array
    {
        return $this->components;
    }

    /**
     * @return null|array<int, DevicePreferenceDefinitionInterface>
     */
    public function getPreferences(): ?array
    {
        return $this->preferences;
    }

    public function getRestrictions(): ?DeviceRestrictionInterface
    {
        return $this->restrictions;
    }

    /**
     * @param null|array<int, DeviceProfileComponentInterface> $value
     */
    public function setComponents(?array $value): DeviceProfileDetailsInterface
    {
        $this->components = $value;

        return $this;
    }

    /**
     * @param null|array<int, DevicePreferenceDefinitionInterface> $value
     */
    public function setPreferences(?array $value): DeviceProfileDetailsInterface
    {
        $this->preferences = $value;

        return $this;
    }

    public function setRestrictions(?DeviceRestrictionInterface $value): DeviceProfileDetailsInterface
    {
        $this->restrictions = $value;

        return $this;
    }
}
