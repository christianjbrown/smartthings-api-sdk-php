<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StepperForPanelItemCommandInterface
{
    public function getArgumentType(): ?string;

    public function getDecrease(): ?string;

    public function getIncrease(): ?string;

    public function getName(): ?string;

    public function setArgumentType(?string $value): self;

    public function setDecrease(?string $value): self;

    public function setIncrease(?string $value): self;

    public function setName(?string $value): self;
}
