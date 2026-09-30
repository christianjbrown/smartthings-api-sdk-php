<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListWithAvailableSizeInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array;

    public function getCommand(): ?ListWithAvailableSizeCommandInterface;

    public function getState(): ?ListWithAvailableSizeStateInterface;

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): self;

    public function setState(?ListWithAvailableSizeStateInterface $value): self;
}
