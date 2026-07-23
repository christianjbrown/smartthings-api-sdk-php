<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DevicePreferenceInterface
{
    public function getName(): string;

    public function getPreferenceType(): ?string;

    public function getValue(): null|bool|float|int|string;

    public function setName(string $value): self;

    public function setPreferenceType(?string $value): self;

    public function setValue(null|bool|float|int|string $value): self;
}
