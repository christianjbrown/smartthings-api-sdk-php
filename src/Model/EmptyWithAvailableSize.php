<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EmptyWithAvailableSize implements EmptyWithAvailableSizeInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): EmptyWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }
}
