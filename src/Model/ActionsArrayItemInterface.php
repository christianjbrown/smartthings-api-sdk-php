<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ActionsArrayItemInterface
{
    public function getCapability(): string;

    public function getComponent(): ?string;

    public function getDisplayType(): string;

    public function getGroup(): ?string;

    public function getPlayPause(): ?PlayPauseInterface;

    public function getPlayStop(): ?PlayStopInterface;

    public function getPushButton(): ?PushButtonInterface;

    public function getStandbyPowerSwitch(): ?StandbyPowerSwitchForDashboardInterface;

    public function getStatelessPowerToggle(): ?StatelessPowerToggleForDashboardInterface;

    public function getSwitch(): ?SwitchForDashboardInterface;

    public function getToggleSwitch(): ?ToggleSwitchForDashboardInterface;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    public function setComponent(?string $value): self;

    public function setGroup(?string $value): self;

    public function setPlayPause(?PlayPauseInterface $value): self;

    public function setPlayStop(?PlayStopInterface $value): self;

    public function setPushButton(?PushButtonInterface $value): self;

    public function setStandbyPowerSwitch(?StandbyPowerSwitchForDashboardInterface $value): self;

    public function setStatelessPowerToggle(?StatelessPowerToggleForDashboardInterface $value): self;

    public function setSwitch(?SwitchForDashboardInterface $value): self;

    public function setToggleSwitch(?ToggleSwitchForDashboardInterface $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
