<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityInterface
{
    public function getId(): string;

    public function getName(): ?string;

    public function getStatus(): ?string;

    public function getVersion(): ?int;

    public function setId(string $value): self;

    public function setName(?string $value): self;

    public function setStatus(?string $value): self;

    public function setVersion(?int $value): self;
}
