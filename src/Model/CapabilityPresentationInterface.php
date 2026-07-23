<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityPresentationInterface
{
    public function getId(): string;

    public function getVersion(): ?int;

    public function setId(string $value): self;

    public function setVersion(?int $value): self;
}
