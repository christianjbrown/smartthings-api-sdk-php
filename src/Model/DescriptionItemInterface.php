<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DescriptionItemInterface
{
    public function getLabel(): string;

    public function getOperator(): ?string;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
