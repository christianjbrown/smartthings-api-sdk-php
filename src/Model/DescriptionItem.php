<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DescriptionItem implements DescriptionItemInterface
{
    private ?string $label;
    private ?string $operator = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(?string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
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

    public function setOperator(?string $value): DescriptionItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): DescriptionItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
