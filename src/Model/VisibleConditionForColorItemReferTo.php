<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class VisibleConditionForColorItemReferTo implements VisibleConditionForColorItemReferToInterface
{
    private ?string $capability;
    private ?string $component;
    private ?string $value;
    private ?string $valueType = null;
    private ?int $version = null;

    public function __construct(?string $component, ?string $capability, ?string $value)
    {
        $this->component = $component;
        $this->capability = $capability;
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

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setValueType(?string $value): VisibleConditionForColorItemReferToInterface
    {
        $this->valueType = $value;

        return $this;
    }

    public function setVersion(?int $value): VisibleConditionForColorItemReferToInterface
    {
        $this->version = $value;

        return $this;
    }
}
