<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForPanelItem implements ListForPanelItemInterface
{
    private ListForPanelItemCommandInterface $command;
    private string $size;
    private ?ListForPanelItemStateInterface $state = null;

    public function __construct(ListForPanelItemCommandInterface $command, string $size)
    {
        $this->command = $command;
        $this->size = $size;
    }

    public function getCommand(): ListForPanelItemCommandInterface
    {
        return $this->command;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getState(): ?ListForPanelItemStateInterface
    {
        return $this->state;
    }

    public function setState(?ListForPanelItemStateInterface $value): ListForPanelItemInterface
    {
        $this->state = $value;

        return $this;
    }
}
