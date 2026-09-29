<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DescriptionsInAutomationInterface
{
    /**
     * @return null|array<int, DescriptionItemInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, DescriptionItemInterface>
     */
    public function getConditions(): ?array;

    /**
     * @param null|array<int, DescriptionItemInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, DescriptionItemInterface> $value
     */
    public function setConditions(?array $value): self;
}
