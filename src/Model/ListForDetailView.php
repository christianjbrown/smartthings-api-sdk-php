<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForDetailView implements ListForDetailViewInterface
{
    private ListWithAvailableSizeCommandInterface $command;
    private ?ListWithAvailableSizeStateInterface $state = null;

    public function __construct(ListWithAvailableSizeCommandInterface $command)
    {
        $this->command = $command;
    }

    public function getCommand(): ListWithAvailableSizeCommandInterface
    {
        return $this->command;
    }

    public function getState(): ?ListWithAvailableSizeStateInterface
    {
        return $this->state;
    }

    public function setState(?ListWithAvailableSizeStateInterface $value): ListForDetailViewInterface
    {
        $this->state = $value;

        return $this;
    }
}
