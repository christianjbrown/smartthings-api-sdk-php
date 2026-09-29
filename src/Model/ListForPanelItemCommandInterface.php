<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ListForPanelItemCommandInterface
{
    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array;

    public function getArgumentType(): ?string;

    public function getDescription(): ?string;

    public function getName(): ?string;

    public function getSupportedValues(): ?string;

    public function setArgumentType(?string $value): self;

    public function setDescription(?string $value): self;

    public function setName(?string $value): self;

    public function setSupportedValues(?string $value): self;
}
