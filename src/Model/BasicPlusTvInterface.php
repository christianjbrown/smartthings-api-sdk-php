<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusTvInterface
{
    /**
     * @return array<int, ButtonForTvInterface>
     */
    public function getButtons(): array;

    public function getChannel(): ?BasicPlusTvChannelInterface;

    public function getDirectionalPad(): ?BasicPlusTvDirectionalPadInterface;

    public function getHideDashboardActions(): ?bool;

    public function getOperator(): ?string;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function getVolume(): ?BasicPlusTvVolumeInterface;

    public function setChannel(?BasicPlusTvChannelInterface $value): self;

    public function setDirectionalPad(?BasicPlusTvDirectionalPadInterface $value): self;

    public function setHideDashboardActions(?bool $value): self;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;

    public function setVolume(?BasicPlusTvVolumeInterface $value): self;
}
