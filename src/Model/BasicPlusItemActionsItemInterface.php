<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusItemActionsItemInterface
{
    public function getArgument(): ?string;

    public function getArgumentType(): ?string;

    public function getCapability(): ?string;

    public function getCommand(): ?string;

    public function getComponent(): ?string;

    public function getIconUrl(): ?string;

    public function getOperator(): ?string;

    public function getVersion(): ?int;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setArgument(?string $value): self;

    public function setArgumentType(?string $value): self;

    public function setIconUrl(?string $value): self;

    public function setOperator(?string $value): self;

    public function setVersion(?int $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
