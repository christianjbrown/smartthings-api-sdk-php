<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTv implements BasicPlusTvInterface
{
    /**
     * @var array<int, ButtonForTvInterface>
     */
    private array $buttons;
    private ?BasicPlusTvChannelInterface $channel = null;
    private ?BasicPlusTvDirectionalPadInterface $directionalPad = null;
    private ?bool $hideDashboardActions = null;
    private ?string $operator = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;
    private ?BasicPlusTvVolumeInterface $volume = null;

    /**
     * @phpstan-param array<int, ButtonForTvInterface> $buttons
     */
    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * @return array<int, ButtonForTvInterface>
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getChannel(): ?BasicPlusTvChannelInterface
    {
        return $this->channel;
    }

    public function getDirectionalPad(): ?BasicPlusTvDirectionalPadInterface
    {
        return $this->directionalPad;
    }

    public function getHideDashboardActions(): ?bool
    {
        return $this->hideDashboardActions;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function getVolume(): ?BasicPlusTvVolumeInterface
    {
        return $this->volume;
    }

    public function setChannel(?BasicPlusTvChannelInterface $value): BasicPlusTvInterface
    {
        $this->channel = $value;

        return $this;
    }

    public function setDirectionalPad(?BasicPlusTvDirectionalPadInterface $value): BasicPlusTvInterface
    {
        $this->directionalPad = $value;

        return $this;
    }

    public function setHideDashboardActions(?bool $value): BasicPlusTvInterface
    {
        $this->hideDashboardActions = $value;

        return $this;
    }

    public function setOperator(?string $value): BasicPlusTvInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): BasicPlusTvInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }

    public function setVolume(?BasicPlusTvVolumeInterface $value): BasicPlusTvInterface
    {
        $this->volume = $value;

        return $this;
    }
}
