<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusStateBoardItemInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getCapability(): string;

    /**
     * @return null|array<int, BasicPlusStateBoardColorsInterface>
     */
    public function getColors(): ?array;

    public function getComponent(): string;

    public function getIconUrl(): ?string;

    public function getLabel(): string;

    public function getOperator(): ?string;

    public function getUnit(): ?string;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function getVersion(): ?int;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    /**
     * @param null|array<int, BasicPlusStateBoardColorsInterface> $value
     */
    public function setColors(?array $value): self;

    public function setIconUrl(?string $value): self;

    public function setOperator(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValueType(?string $value): self;

    public function setVersion(?int $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
