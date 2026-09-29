<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ActionItem implements ActionItemInterface
{
    private string $displayType;
    private ?string $group = null;
    private ?PlayPauseInterface $playPause = null;
    private ?PlayStopInterface $playStop = null;
    private ?PushButtonInterface $pushButton = null;
    private ?StandbyPowerSwitchForDashboardInterface $standbyPowerSwitch = null;
    private ?StatelessPowerToggleForDashboardInterface $statelessPowerToggle = null;
    private ?SwitchForDashboardInterface $switch = null;
    private ?ToggleSwitchForDashboardInterface $toggleSwitch = null;

    public function __construct(string $displayType)
    {
        $this->displayType = $displayType;
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

    public function setGroup(?string $value): ActionItemInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setPlayPause(?PlayPauseInterface $value): ActionItemInterface
    {
        $this->playPause = $value;

        return $this;
    }

    public function setPlayStop(?PlayStopInterface $value): ActionItemInterface
    {
        $this->playStop = $value;

        return $this;
    }

    public function setPushButton(?PushButtonInterface $value): ActionItemInterface
    {
        $this->pushButton = $value;

        return $this;
    }

    public function setStandbyPowerSwitch(?StandbyPowerSwitchForDashboardInterface $value): ActionItemInterface
    {
        $this->standbyPowerSwitch = $value;

        return $this;
    }

    public function setStatelessPowerToggle(?StatelessPowerToggleForDashboardInterface $value): ActionItemInterface
    {
        $this->statelessPowerToggle = $value;

        return $this;
    }

    public function setSwitch(?SwitchForDashboardInterface $value): ActionItemInterface
    {
        $this->switch = $value;

        return $this;
    }

    public function setToggleSwitch(?ToggleSwitchForDashboardInterface $value): ActionItemInterface
    {
        $this->toggleSwitch = $value;

        return $this;
    }
}
