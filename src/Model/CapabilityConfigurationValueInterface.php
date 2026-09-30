<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityConfigurationValueInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getEnabledValues(): ?array;

    public function getKey(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getStep(): ?float;

    /**
     * @param null|array<int, string> $value
     */
    public function setEnabledValues(?array $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setStep(?float $value): self;
}
