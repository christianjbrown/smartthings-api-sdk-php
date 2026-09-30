<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusTvVolume implements BasicPlusTvVolumeInterface
{
    private ?string $capability;
    private ?BasicPlusTvVolumeCommandInterface $command;
    private ?string $component;
    private ?string $label = null;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?float $step = null;
    private ?string $supportedValues = null;
    private ?string $value = null;
    private ?int $version = null;

    public function __construct(?string $capability, ?string $component, ?BasicPlusTvVolumeCommandInterface $command)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->command = $command;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommand(): ?BasicPlusTvVolumeCommandInterface
    {
        return $this->command;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setLabel(?string $value): BasicPlusTvVolumeInterface
    {
        $this->label = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): BasicPlusTvVolumeInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setStep(?float $value): BasicPlusTvVolumeInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): BasicPlusTvVolumeInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setValue(?string $value): BasicPlusTvVolumeInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusTvVolumeInterface
    {
        $this->version = $value;

        return $this;
    }
}
