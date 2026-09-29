<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Action implements ActionInterface
{
    private ?CommandActionInterface $command = null;
    private ?EveryActionInterface $every = null;
    private ?IfActionInterface $if = null;
    private ?LimitActionInterface $limit = null;
    private ?LocationActionInterface $location = null;
    private ?SceneActionInterface $scene = null;
    private ?SleepActionInterface $sleep = null;
    private ?ToggleActionInterface $toggle = null;

    public function getCommand(): ?CommandActionInterface
    {
        return $this->command;
    }

    public function getEvery(): ?EveryActionInterface
    {
        return $this->every;
    }

    public function getIf(): ?IfActionInterface
    {
        return $this->if;
    }

    public function getLimit(): ?LimitActionInterface
    {
        return $this->limit;
    }

    public function getLocation(): ?LocationActionInterface
    {
        return $this->location;
    }

    public function getScene(): ?SceneActionInterface
    {
        return $this->scene;
    }

    public function getSleep(): ?SleepActionInterface
    {
        return $this->sleep;
    }

    public function getToggle(): ?ToggleActionInterface
    {
        return $this->toggle;
    }

    public function setCommand(?CommandActionInterface $value): ActionInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setEvery(?EveryActionInterface $value): ActionInterface
    {
        $this->every = $value;

        return $this;
    }

    public function setIf(?IfActionInterface $value): ActionInterface
    {
        $this->if = $value;

        return $this;
    }

    public function setLimit(?LimitActionInterface $value): ActionInterface
    {
        $this->limit = $value;

        return $this;
    }

    public function setLocation(?LocationActionInterface $value): ActionInterface
    {
        $this->location = $value;

        return $this;
    }

    public function setScene(?SceneActionInterface $value): ActionInterface
    {
        $this->scene = $value;

        return $this;
    }

    public function setSleep(?SleepActionInterface $value): ActionInterface
    {
        $this->sleep = $value;

        return $this;
    }

    public function setToggle(?ToggleActionInterface $value): ActionInterface
    {
        $this->toggle = $value;

        return $this;
    }
}
