<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusItemProgressBarsItem implements BasicPlusItemProgressBarsItemInterface
{
    private ?BasicPlusProgressBarsBarItemInterface $bar = null;

    /**
     * @var null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    private ?array $footers = null;

    /**
     * @var null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    private ?array $headers = null;
    private ?string $operator = null;

    /**
     * @var null|array<int, VisibleConditionInterface>
     */
    private ?array $visibleConditions = null;

    public function getBar(): ?BasicPlusProgressBarsBarItemInterface
    {
        return $this->bar;
    }

    /**
     * @return null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    public function getFooters(): ?array
    {
        return $this->footers;
    }

    /**
     * @return null|array<int, BasicPlusProgressBarsStateItemInterface>
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    /**
     * @return null|array<int, VisibleConditionInterface>
     */
    public function getVisibleConditions(): ?array
    {
        return $this->visibleConditions;
    }

    public function setBar(?BasicPlusProgressBarsBarItemInterface $value): BasicPlusItemProgressBarsItemInterface
    {
        $this->bar = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $value
     */
    public function setFooters(?array $value): BasicPlusItemProgressBarsItemInterface
    {
        $this->footers = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $value
     */
    public function setHeaders(?array $value): BasicPlusItemProgressBarsItemInterface
    {
        $this->headers = $value;

        return $this;
    }

    public function setOperator(?string $value): BasicPlusItemProgressBarsItemInterface
    {
        $this->operator = $value;

        return $this;
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $value
     */
    public function setVisibleConditions(?array $value): BasicPlusItemProgressBarsItemInterface
    {
        $this->visibleConditions = $value;

        return $this;
    }
}
