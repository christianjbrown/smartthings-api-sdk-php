<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DashboardInterface
{
    /**
     * @return null|array<int, ActionsArrayItemInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, BasicPlusItemForPresentationInterface>
     */
    public function getBasicPlus(): ?array;

    public function getGroupVisibleConditions(): ?GroupVisibleConditionsInterface;

    /**
     * @return null|array<int, StatesArrayItemInterface>
     */
    public function getStates(): ?array;

    /**
     * @param null|array<int, ActionsArrayItemInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, BasicPlusItemForPresentationInterface> $value
     */
    public function setBasicPlus(?array $value): self;

    public function setGroupVisibleConditions(?GroupVisibleConditionsInterface $value): self;

    /**
     * @param null|array<int, StatesArrayItemInterface> $value
     */
    public function setStates(?array $value): self;
}
