<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StepperForPanelItemCommand implements StepperForPanelItemCommandInterface
{
    private ?string $argumentType = null;
    private ?string $decrease = null;
    private ?string $increase = null;
    private ?string $name = null;

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getDecrease(): ?string
    {
        return $this->decrease;
    }

    public function getIncrease(): ?string
    {
        return $this->increase;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setArgumentType(?string $value): StepperForPanelItemCommandInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setDecrease(?string $value): StepperForPanelItemCommandInterface
    {
        $this->decrease = $value;

        return $this;
    }

    public function setIncrease(?string $value): StepperForPanelItemCommandInterface
    {
        $this->increase = $value;

        return $this;
    }

    public function setName(?string $value): StepperForPanelItemCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
