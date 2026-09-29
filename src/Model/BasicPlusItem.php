<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusItem implements BasicPlusItemInterface
{
    /**
     * @var null|array<int, BasicPlusItemActionsItemInterface>
     */
    private ?array $actions = null;
    private ?BasicPlusCameraInterface $camera = null;
    private string $displayType;
    private ?BasicPlusLightInterface $light = null;
    private ?PanelForDeviceConfigInterface $panel = null;

    /**
     * @var null|array<int, BasicPlusItemProgressBarsItemInterface>
     */
    private ?array $progressBars = null;

    /**
     * @var null|array<int, BasicPlusStateBoardItemInterface>
     */
    private ?array $stateBoard = null;
    private ?BasicPlusTvInterface $tv = null;

    public function __construct(string $displayType)
    {
        $this->displayType = $displayType;
    }

    /**
     * @return null|array<int, BasicPlusItemActionsItemInterface>
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }

    public function getCamera(): ?BasicPlusCameraInterface
    {
        return $this->camera;
    }

    public function getDisplayType(): string
    {
        return $this->displayType;
    }

    public function getLight(): ?BasicPlusLightInterface
    {
        return $this->light;
    }

    public function getPanel(): ?PanelForDeviceConfigInterface
    {
        return $this->panel;
    }

    /**
     * @return null|array<int, BasicPlusItemProgressBarsItemInterface>
     */
    public function getProgressBars(): ?array
    {
        return $this->progressBars;
    }

    /**
     * @return null|array<int, BasicPlusStateBoardItemInterface>
     */
    public function getStateBoard(): ?array
    {
        return $this->stateBoard;
    }

    public function getTv(): ?BasicPlusTvInterface
    {
        return $this->tv;
    }

    /**
     * @param null|array<int, BasicPlusItemActionsItemInterface> $value
     */
    public function setActions(?array $value): BasicPlusItemInterface
    {
        $this->actions = $value;

        return $this;
    }

    public function setCamera(?BasicPlusCameraInterface $value): BasicPlusItemInterface
    {
        $this->camera = $value;

        return $this;
    }

    public function setLight(?BasicPlusLightInterface $value): BasicPlusItemInterface
    {
        $this->light = $value;

        return $this;
    }

    public function setPanel(?PanelForDeviceConfigInterface $value): BasicPlusItemInterface
    {
        $this->panel = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusItemProgressBarsItemInterface> $value
     */
    public function setProgressBars(?array $value): BasicPlusItemInterface
    {
        $this->progressBars = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusStateBoardItemInterface> $value
     */
    public function setStateBoard(?array $value): BasicPlusItemInterface
    {
        $this->stateBoard = $value;

        return $this;
    }

    public function setTv(?BasicPlusTvInterface $value): BasicPlusItemInterface
    {
        $this->tv = $value;

        return $this;
    }
}
