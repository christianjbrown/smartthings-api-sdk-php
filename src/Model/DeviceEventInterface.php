<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceEventInterface
{
    public function getAttribute(): ?string;

    public function getCapability(): ?string;

    public function getCommandId(): ?string;

    public function getComponent(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getData(): ?array;

    public function getUnit(): ?string;

    public function getValue(): mixed;

    public function setAttribute(?string $value): self;

    public function setCapability(?string $value): self;

    public function setCommandId(?string $value): self;

    public function setComponent(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): self;

    public function setUnit(?string $value): self;
}
