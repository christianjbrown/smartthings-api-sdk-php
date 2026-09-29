<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusProgressBarsBarItemInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getValue(): string;

    public function getValueType(): ?string;

    public function getVersion(): ?int;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setValueType(?string $value): self;

    public function setVersion(?int $value): self;
}
