<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusItemProgressBarsItemInterface
{
    public function getBar(): ?BasicPlusProgressBarsBarItemInterface;

    /**
     * @return null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    public function getFooters(): ?array;

    /**
     * @return null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    public function getHeaders(): ?array;

    public function getOperator(): ?string;

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array;

    public function setBar(?BasicPlusProgressBarsBarItemInterface $value): self;

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $value
     */
    public function setFooters(?array $value): self;

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $value
     */
    public function setHeaders(?array $value): self;

    public function setOperator(?string $value): self;

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): self;
}
