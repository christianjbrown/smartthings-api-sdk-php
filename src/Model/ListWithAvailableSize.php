<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListWithAvailableSize implements ListWithAvailableSizeInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;
    private ?ListWithAvailableSizeCommandInterface $command;
    private ?ListWithAvailableSizeStateInterface $state = null;

    public function __construct(?ListWithAvailableSizeCommandInterface $command)
    {
        $this->command = $command;
    }

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
    }

    public function getCommand(): ?ListWithAvailableSizeCommandInterface
    {
        return $this->command;
    }

    public function getState(): ?ListWithAvailableSizeStateInterface
    {
        return $this->state;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): ListWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }

    public function setState(?ListWithAvailableSizeStateInterface $value): ListWithAvailableSizeInterface
    {
        $this->state = $value;

        return $this;
    }
}
