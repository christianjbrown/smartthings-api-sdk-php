<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ActionInterface
{
    public function getCommand(): ?CommandActionInterface;

    public function getEvery(): ?EveryActionInterface;

    public function getIf(): ?IfActionInterface;

    public function getLimit(): ?LimitActionInterface;

    public function getLocation(): ?LocationActionInterface;

    public function getScene(): ?SceneActionInterface;

    public function getSleep(): ?SleepActionInterface;

    public function getToggle(): ?ToggleActionInterface;

    public function setCommand(?CommandActionInterface $value): self;

    public function setEvery(?EveryActionInterface $value): self;

    public function setIf(?IfActionInterface $value): self;

    public function setLimit(?LimitActionInterface $value): self;

    public function setLocation(?LocationActionInterface $value): self;

    public function setScene(?SceneActionInterface $value): self;

    public function setSleep(?SleepActionInterface $value): self;

    public function setToggle(?ToggleActionInterface $value): self;
}
