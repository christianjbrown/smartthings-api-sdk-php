<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Dashboard implements DashboardInterface
{
    /**
     * @var null|array<int, ActionsArrayItemInterface>
     */
    private ?array $actions = null;

    /**
     * @var null|array<int, BasicPlusItemForPresentationInterface>
     */
    private ?array $basicPlus = null;
    private ?GroupVisibleConditionsInterface $groupVisibleConditions = null;

    /**
     * @var null|array<int, StatesArrayItemInterface>
     */
    private ?array $states = null;

    /**
     * @return null|array<int, ActionsArrayItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    /**
     * @return null|array<int, BasicPlusItemForPresentationInterface>
     */
    public function getBasicPlus(): ?array
    {
        return $this->basicPlus;
    }

    public function getGroupVisibleConditions(): ?GroupVisibleConditionsInterface
    {
        return $this->groupVisibleConditions;
    }

    /**
     * @return null|array<int, StatesArrayItemInterface>
     */
    public function getStates(): ?array
    {
        return $this->states;
    }

    /**
     * @param null|array<int, ActionsArrayItemInterface> $value
     */
    public function setActions(?array $value): DashboardInterface
    {
        $this->actions = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusItemForPresentationInterface> $value
     */
    public function setBasicPlus(?array $value): DashboardInterface
    {
        $this->basicPlus = $value;

        return $this;
    }

    public function setGroupVisibleConditions(?GroupVisibleConditionsInterface $value): DashboardInterface
    {
        $this->groupVisibleConditions = $value;

        return $this;
    }

    /**
     * @param null|array<int, StatesArrayItemInterface> $value
     */
    public function setStates(?array $value): DashboardInterface
    {
        $this->states = $value;

        return $this;
    }
}
