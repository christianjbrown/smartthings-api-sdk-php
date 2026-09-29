<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusItemForPresentationInterface
{
    /**
     * @return null|array<int, BasicPlusItemActionsItemInterface>
     */
    public function getActions(): ?array;

    public function getCamera(): ?BasicPlusCameraInterface;

    public function getDisplayType(): string;

    public function getLight(): ?BasicPlusLightInterface;

    public function getPanel(): ?PanelForDevicePresentationInterface;

    /**
     * @return null|array<int, BasicPlusItemProgressBarsItemInterface>
     */
    public function getProgressBars(): ?array;

    /**
     * @return null|array<int, BasicPlusStateBoardItemInterface>
     */
    public function getStateBoard(): ?array;

    public function getTv(): ?BasicPlusTvInterface;

    /**
     * @param null|array<int, BasicPlusItemActionsItemInterface> $value
     */
    public function setActions(?array $value): self;

    public function setCamera(?BasicPlusCameraInterface $value): self;

    public function setLight(?BasicPlusLightInterface $value): self;

    public function setPanel(?PanelForDevicePresentationInterface $value): self;

    /**
     * @param null|array<int, BasicPlusItemProgressBarsItemInterface> $value
     */
    public function setProgressBars(?array $value): self;

    /**
     * @param null|array<int, BasicPlusStateBoardItemInterface> $value
     */
    public function setStateBoard(?array $value): self;

    public function setTv(?BasicPlusTvInterface $value): self;
}
