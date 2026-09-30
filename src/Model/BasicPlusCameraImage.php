<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusCameraImage implements BasicPlusCameraImageInterface
{
    private ?string $capability;
    private ?string $component;
    private ?string $value;
    private ?int $version = null;

    public function __construct(?string $capability, ?string $component, ?string $value)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->value = $value;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $value): BasicPlusCameraImageInterface
    {
        $this->version = $value;

        return $this;
    }
}
