<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RuleDeviceCommandInterface
{
    /**
     * @return null|mixed[]
     */
    public function getArguments(): ?array;

    public function getCapability(): string;

    public function getCommand(): string;

    public function getCommandId(): ?string;

    public function getComponent(): ?string;

    /**
     * @param null|mixed[] $value
     */
    public function setArguments(?array $value): self;

    public function setCommandId(?string $value): self;

    public function setComponent(?string $value): self;
}
