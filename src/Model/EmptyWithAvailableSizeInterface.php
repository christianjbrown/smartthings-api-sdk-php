<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EmptyWithAvailableSizeInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array;

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): self;
}
