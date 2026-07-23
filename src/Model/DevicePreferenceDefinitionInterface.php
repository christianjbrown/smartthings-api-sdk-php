<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DevicePreferenceDefinitionInterface
{
    public function getDescription(): ?string;

    public function getName(): ?string;

    public function getPreferenceId(): string;

    public function getPreferenceType(): ?string;

    public function getRequired(): ?bool;

    public function getTitle(): ?string;

    public function setDescription(?string $value): self;

    public function setName(?string $value): self;

    public function setPreferenceId(string $value): self;

    public function setPreferenceType(?string $value): self;

    public function setRequired(?bool $value): self;

    public function setTitle(?string $value): self;
}
