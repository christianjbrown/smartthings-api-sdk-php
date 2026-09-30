<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusItemForPresentation implements BasicPlusItemForPresentationInterface
{
    /**
     * @var null|array<int, BasicPlusItemActionsItemInterface>
     */
    private ?array $actions = null;
    private ?BasicPlusCameraInterface $camera = null;
    private ?string $displayType;
    private ?BasicPlusLightInterface $light = null;
    private ?PanelForDevicePresentationInterface $panel = null;

    /**
     * @var null|array<int, BasicPlusItemProgressBarsItemInterface>
     */
    private ?array $progressBars = null;

    /**
     * @var null|array<int, BasicPlusStateBoardItemInterface>
     */
    private ?array $stateBoard = null;
    private ?BasicPlusTvInterface $tv = null;

    public function __construct(?string $displayType)
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

    public function getDisplayType(): ?string
    {
        return $this->displayType;
    }

    public function getLight(): ?BasicPlusLightInterface
    {
        return $this->light;
    }

    public function getPanel(): ?PanelForDevicePresentationInterface
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
    public function setActions(?array $value): BasicPlusItemForPresentationInterface
    {
        $this->actions = $value;

        return $this;
    }

    public function setCamera(?BasicPlusCameraInterface $value): BasicPlusItemForPresentationInterface
    {
        $this->camera = $value;

        return $this;
    }

    public function setLight(?BasicPlusLightInterface $value): BasicPlusItemForPresentationInterface
    {
        $this->light = $value;

        return $this;
    }

    public function setPanel(?PanelForDevicePresentationInterface $value): BasicPlusItemForPresentationInterface
    {
        $this->panel = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusItemProgressBarsItemInterface> $value
     */
    public function setProgressBars(?array $value): BasicPlusItemForPresentationInterface
    {
        $this->progressBars = $value;

        return $this;
    }

    /**
     * @param null|array<int, BasicPlusStateBoardItemInterface> $value
     */
    public function setStateBoard(?array $value): BasicPlusItemForPresentationInterface
    {
        $this->stateBoard = $value;

        return $this;
    }

    public function setTv(?BasicPlusTvInterface $value): BasicPlusItemForPresentationInterface
    {
        $this->tv = $value;

        return $this;
    }
}
