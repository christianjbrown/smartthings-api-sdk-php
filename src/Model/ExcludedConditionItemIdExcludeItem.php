<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedConditionItemIdExcludeItem implements ExcludedConditionItemIdExcludeItemInterface
{
    /**
     * @var null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    private ?array $attributes = null;
    private string $capability;
    private ?string $component = null;
    private ?int $version = null;

    public function __construct(string $capability)
    {
        $this->capability = $capability;
    }

    /**
     * @return null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface> $value
     */
    public function setAttributes(?array $value): ExcludedConditionItemIdExcludeItemInterface
    {
        $this->attributes = $value;

        return $this;
    }

    public function setComponent(?string $value): ExcludedConditionItemIdExcludeItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setVersion(?int $value): ExcludedConditionItemIdExcludeItemInterface
    {
        $this->version = $value;

        return $this;
    }
}
