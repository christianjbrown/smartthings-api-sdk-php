<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationActionExecutionResultInterface
{
    public function getLocationId(): ?string;

    public function getMode(): ?string;

    public function getResult(): ?string;

    public function getSecurity(): ?SecurityStateInterface;

    public function setLocationId(?string $value): self;

    public function setMode(?string $value): self;

    public function setResult(?string $value): self;

    public function setSecurity(?SecurityStateInterface $value): self;
}
