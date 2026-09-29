<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedDeviceConditionConfigEntryInterface
{
    public function getCapability(): string;

    public function getComponent(): string;

    /**
     * @return null|array<int, ExcludedConditionItemIdInterface>
     */
    public function getExclusion(): ?array;

    /**
     * @return null|array<int, PatchItemInterface>
     */
    public function getPatch(): ?array;

    /**
     * @return null|array<int, CapabilityValueInterface>
     */
    public function getValues(): ?array;

    public function getVersion(): ?int;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    /**
     * @param null|array<int, ExcludedConditionItemIdInterface> $value
     */
    public function setExclusion(?array $value): self;

    /**
     * @param null|array<int, PatchItemInterface> $value
     */
    public function setPatch(?array $value): self;

    /**
     * @param null|array<int, CapabilityValueInterface> $value
     */
    public function setValues(?array $value): self;

    public function setVersion(?int $value): self;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
