<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusProgressBarsBarItem implements BasicPlusProgressBarsBarItemInterface
{
    private string $capability;
    private string $component;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private string $value;
    private ?string $valueType = null;
    private ?int $version = null;

    public function __construct(string $capability, string $component, string $value)
    {
        $this->capability = $capability;
        $this->component = $component;
        $this->value = $value;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function getValue(): string
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

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): BasicPlusProgressBarsBarItemInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setValueType(?string $value): BasicPlusProgressBarsBarItemInterface
    {
        $this->valueType = $value;

        return $this;
    }

    public function setVersion(?int $value): BasicPlusProgressBarsBarItemInterface
    {
        $this->version = $value;

        return $this;
    }
}
