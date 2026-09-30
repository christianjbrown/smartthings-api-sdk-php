<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface StateWithAvailableSizeInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array;

    public function getLabel(): ?string;

    public function getUnit(): ?string;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): self;

    public function setUnit(?string $value): self;
}
