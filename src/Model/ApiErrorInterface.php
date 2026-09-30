<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ApiErrorInterface
{
    public function getCode(): ?string;

    /**
     * @return array<int, ApiErrorInterface>
     */
    public function getDetails(): array;

    public function getMessage(): ?string;

    public function getTarget(): ?string;

    public function setCode(?string $value): self;

    /**
     * @param array<int, ApiErrorInterface> $value
     */
    public function setDetails(array $value): self;

    public function setMessage(?string $value): self;

    public function setTarget(?string $value): self;
}
