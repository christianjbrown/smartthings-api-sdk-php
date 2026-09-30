<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandActionExecutionResultInterface
{
    /**
     * @return array<int, array<array-key, mixed>>
     */
    public function getArguments(): array;

    public function getCapability(): ?string;

    public function getCommand(): ?string;

    public function getComponent(): ?string;

    public function getDeviceId(): ?string;

    public function getResult(): ?string;

    /**
     * @param array<int, array<array-key, mixed>> $value
     */
    public function setArguments(array $value): self;

    public function setCapability(?string $value): self;

    public function setCommand(?string $value): self;

    public function setComponent(?string $value): self;

    public function setDeviceId(?string $value): self;

    public function setResult(?string $value): self;
}
