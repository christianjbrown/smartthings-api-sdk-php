<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusProgressBarsStateItemInterface
{
    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array;

    public function getCapability(): string;

    public function getComponent(): string;

    /**
     * @return null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    public function getFormatInfo(): ?array;

    public function getIconUrl(): ?string;

    public function getLabel(): string;

    public function getPlacement(): ?string;

    public function getVersion(): ?int;

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): self;

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $value
     */
    public function setFormatInfo(?array $value): self;

    public function setIconUrl(?string $value): self;

    public function setPlacement(?string $value): self;

    public function setVersion(?int $value): self;
}
