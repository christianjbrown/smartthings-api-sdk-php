<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusStateBoardColorsInterface
{
    public function getColor(): ?string;

    public function getOperator(): ?string;

    /**
     * @return null|array<int, VisibleConditionForColorItemInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, VisibleConditionForColorItemInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
