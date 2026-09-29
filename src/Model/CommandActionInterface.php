<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandActionInterface
{
    /**
     * @return array<int, RuleDeviceCommandInterface>
     */
    public function getCommands(): array;

    /**
     * @return array<int, string>
     */
    public function getDevices(): array;

    public function getSequence(): ?CommandSequenceInterface;

    public function setSequence(?CommandSequenceInterface $value): self;
}
