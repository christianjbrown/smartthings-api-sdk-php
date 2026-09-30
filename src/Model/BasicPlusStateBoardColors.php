<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusStateBoardColors implements BasicPlusStateBoardColorsInterface
{
    private ?string $color;
    private ?string $operator = null;

    /**
     * @var null|array<int, VisibleConditionForColorItemInterface>
     */
    private ?array $visibleConditions = null;

    public function __construct(?string $color)
    {
        $this->color = $color;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     * @return null|array<int, VisibleConditionForColorItemInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function setOperator(?string $value): BasicPlusStateBoardColorsInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionForColorItemInterface> $value
     */
    public function setVisibleConditions(?array $value): BasicPlusStateBoardColorsInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
