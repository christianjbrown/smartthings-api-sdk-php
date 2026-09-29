<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ClustersInterface
{
    /**
     * @return null|array<int, int>
     */
    public function getClient(): ?array;

    /**
     * @return null|array<int, int>
     */
    public function getServer(): ?array;

    /**
     * @param null|array<int, int> $value
     */
    public function setClient(?array $value): self;

    /**
     * @param null|array<int, int> $value
     */
    public function setServer(?array $value): self;
}
