<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForPanelItemInterface
{
    public function getCommand(): ListForPanelItemCommandInterface;

    public function getSize(): string;

    public function getState(): ?ListForPanelItemStateInterface;

    public function setState(?ListForPanelItemStateInterface $value): self;
}
