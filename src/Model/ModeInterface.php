<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ModeInterface
{
    /**
     * @return array<int, string>
     */
    public function getAllowed(): array;

    public function getId(): string;

    public function getLabel(): ?string;

    public function getName(): ?string;

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): self;

    public function setId(string $value): self;

    public function setLabel(?string $value): self;

    public function setName(?string $value): self;
}
