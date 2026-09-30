<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForDetailViewInterface
{
    public function getCommand(): ?ListWithAvailableSizeCommandInterface;

    public function getState(): ?ListWithAvailableSizeStateInterface;

    public function setState(?ListWithAvailableSizeStateInterface $value): self;
}
