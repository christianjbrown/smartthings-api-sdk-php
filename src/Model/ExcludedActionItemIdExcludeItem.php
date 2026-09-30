<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedActionItemIdExcludeItem implements ExcludedActionItemIdExcludeItemInterface
{
    private ?string $capability;

    /**
     * @var null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    private ?array $commands = null;
    private ?string $component = null;
    private ?int $version = null;

    public function __construct(?string $capability)
    {
        $this->capability = $capability;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    /**
     * @return null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
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
    public function setCommands(?array $value): ExcludedActionItemIdExcludeItemInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setComponent(?string $value): ExcludedActionItemIdExcludeItemInterface
    {
        $this->component = $value;

        return $this;
    }

    public function setVersion(?int $value): ExcludedActionItemIdExcludeItemInterface
    {
        $this->version = $value;

        return $this;
    }
}
