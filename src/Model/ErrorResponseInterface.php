<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ErrorResponseInterface
{
    public function getError(): ?ApiErrorInterface;

    public function getRequestId(): ?string;

    public function setError(?ApiErrorInterface $value): self;

    public function setRequestId(?string $value): self;
}
