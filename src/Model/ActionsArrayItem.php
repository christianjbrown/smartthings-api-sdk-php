<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ActionsArrayItem implements ActionsArrayItemInterface
{
    private string $capability;
    private ?string $component = null;
    private string $displayType;
    private ?string $group = null;
    private ?PlayPauseInterface $playPause = null;
    private ?PlayStopInterface $playStop = null;
    private ?PushButtonInterface $pushButton = null;
    private ?StandbyPowerSwitchForDashboardInterface $standbyPowerSwitch = null;
    private ?StatelessPowerToggleForDashboardInterface $statelessPowerToggle = null;
    private ?SwitchForDashboardInterface $switch = null;
    private ?ToggleSwitchForDashboardInterface $toggleSwitch = null;
    private ?int $version = null;
    private ?VisibleConditionInterface $visibleCondition = null;

    public function __construct(string $displayType, string $capability)
    {
        $this->displayType = $displayType;
        $this->capability = $capability;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function getPlayPause(): ?PlayPauseInterface
    {
        return $this->playPause;
    }

    public function getPlayStop(): ?PlayStopInterface
    {
        return $this->playStop;
    }

    public function getPushButton(): ?PushButtonInterface
    {
        return $this->pushButton;
    }

    public function getStandbyPowerSwitch(): ?StandbyPowerSwitchForDashboardInterface
    {
        return $this->standbyPowerSwitch;
    }

    public function getStatelessPowerToggle(): ?StatelessPowerToggleForDashboardInterface
    {
        return $this->statelessPowerToggle;
    }

    public function getSwitch(): ?SwitchForDashboardInterface
    {
        return $this->switch;
    }

    public function getToggleSwitch(): ?ToggleSwitchForDashboardInterface
    {
        return $this->toggleSwitch;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    public function setComponent(?string $value): ActionsArrayItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setGroup(?string $value): ActionsArrayItemInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setPlayPause(?PlayPauseInterface $value): ActionsArrayItemInterface
    {
        $this->playPause = $value;

        return $this;
    }

    public function setPlayStop(?PlayStopInterface $value): ActionsArrayItemInterface
    {
        $this->playStop = $value;

        return $this;
    }

    public function setPushButton(?PushButtonInterface $value): ActionsArrayItemInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setStandbyPowerSwitch(?StandbyPowerSwitchForDashboardInterface $value): ActionsArrayItemInterface
    {
        $this->standbyPowerSwitch = $value;

        return $this;
    }

    public function setStatelessPowerToggle(?StatelessPowerToggleForDashboardInterface $value): ActionsArrayItemInterface
    {
        $this->statelessPowerToggle = $value;

        return $this;
    }

    public function setSwitch(?SwitchForDashboardInterface $value): ActionsArrayItemInterface
    {
        $this->switch = $value;

        return $this;
    }

    public function setToggleSwitch(?ToggleSwitchForDashboardInterface $value): ActionsArrayItemInterface
    {
        $this->toggleSwitch = $value;

        return $this;
    }

    public function setVersion(?int $value): ActionsArrayItemInterface
    {
        $this->version = $value;

        return $this;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): ActionsArrayItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
